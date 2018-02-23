<?php

// scheduling Poll 
$entity = elgg_extract('entity', $vars);

$answers = $entity->getVotesByUser();

$poll = $entity->getSlotsGroupedByDays();

// user is not avaiable by default after he voted once
$isNotAvailable = true;
if ($answers) {
	if ($answers[elgg_get_logged_in_user_guid()]) {
		foreach ($answers[elgg_get_logged_in_user_guid()] as $answer) {
			// if there is one answer that not "No", he's availble
			if ($answer !== AnswerValue::NO) {
				$isNotAvailable = false;
			}
		}
	}
}

$date_row = '<td class="empty"></td>';
$slot_row = '<td class="empty"></td>';

$poll_row = '<td>' . elgg_view('input/checkbox', array(
			'label' => "<br>" . elgg_echo("scheduling:form:answer:not:available"),
			'id' => "not-available",
			'name' => "not-available",
			'value' => true,
			'checked' => $isNotAvailable,
		)) . '</td>';

foreach ($poll as $day => $slots) {
	$col_span = count($slots);

	$date = date(elgg_echo('scheduling:date_format'), strtotime($day));
	$date_row .= "<td colspan=\"{$col_span}\">$date</td>";

	foreach ($slots as $timestamp => $slot) {
		$time = date('H:i', (int) $timestamp);
		$slot_row .= "<td>$time</td>";

		if ($entity->getPollType() == PollType::SIMPLE) {
			$valueCheck = $slot->getVoteValue(elgg_get_logged_in_user_entity());
			$valueCheck == AnswerValue::YES ? $checked = True : $checked = False;

			$poll_input = elgg_view('input/checkbox', array(
				'name' => "slot-" . $slot->guid,
				'value' => null,
				'checked' => $checked,
				'class' => 'possible-answer'
			));
		} else {
			$valueCheck = $slot->getVoteValue(elgg_get_logged_in_user_entity());
			$poll_input = " <label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio answerYes' value='3'";
			$valueCheck == AnswerValue::YES ? $poll_input .= " checked='check'>" : $poll_input .= ">";
			$poll_input .= "<a title='" . elgg_echo("scheduling:form:anwser:title:yes") . "'>" . elgg_echo("scheduling:form:anwser:yes") . "</a><br>                        
                            </label>";
			$poll_input .= "<label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio answerMaybe' value='2'";
			$valueCheck == AnswerValue::MAYBE ? $poll_input .= " checked='check'>" : $poll_input .= ">";
			$poll_input .= "    <a title='" . elgg_echo("scheduling:form:anwser:title:maybe") . "'>" . elgg_echo("scheduling:form:anwser:maybe") . "</a><br>
                            </label>";
			$poll_input .= "<label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio answerNo' value='1'";
			$valueCheck == AnswerValue::NO ? $poll_input .= " checked='check'>" : $poll_input .= ">";
			$poll_input .= "    <a title='" . elgg_echo("scheduling:form:anwser:title:no") . "'>" . elgg_echo("scheduling:form:anwser:no") . "</a><br>
                            </label>";
		}

		$poll_row .= "<td>$poll_input</td>";
	}
}

$answer_rows = '';
$cpt_line = 0;
foreach ($answers as $user_guid => $slots) {
	$user = get_entity($user_guid);
	$icon = elgg_view_entity_icon($user, 'tiny');
	// repeat the date and slot line to ease reading this grid
	if ($cpt_line == 10) {
		$answer_rows .= "<tr>" . $date_row . "</tr>";
		$answer_rows .= "<tr>" . $slot_row . "</tr>";

		$cpt_line = 0;
	}
	$answer_row = "<td class='fixed' style=\"padding: 0;\">$icon <br/> $user->name</td>";

	foreach ($slots as $voteValue) {

		if ((int) $voteValue === AnswerValue::YES) {
			$class = 'answerYes';
			$txt = "";
		} else if ((int) $voteValue === AnswerValue::MAYBE) {
			$class = 'answerMaybe';
			$txt = "";
		} else if ((int) $voteValue === AnswerValue::UNDEFINED) {
			$class = 'answerUndefined';
			$txt = "?";
		} else {
			$class = 'answerNo';
			$txt = "";
		}

		$answer_row .= "<td id='' class=\"$class\">$txt</td>";
	}

	$answer_rows .= "<tr>$answer_row</tr>";
	$cpt_line++;
}
// Add a row that shows the total amount of votes for each time slot
$answer_sums = $entity->getVoteCounts();
$voter_num = $entity->getVotersCount();
$sum_row = '<td class="empty">' . $voter_num . '</td>';
foreach ($answer_sums as $sum) {
	$sum_row .= "<td>$sum</td>";
}

$submit_input = elgg_view('input/submit');
$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $entity->guid,
		));

echo <<<FORM
	<div id="elgg-scheduling-answer-container">
		<table class="elgg-table" id="elgg-table-scheduling-answer">
            
			<tr>$date_row</tr>
			<tr>$slot_row</tr>
			$answer_rows
			<tr>$poll_row</tr>
			<tr>$sum_row</tr>
		</table>
	</div>
	<div>
		$guid_input
		$submit_input
	</div>
FORM;

echo "  <script>       
            require(['poll_js'], function() {
                window.poll_js = require('poll_js');
            });     
        </script>";


