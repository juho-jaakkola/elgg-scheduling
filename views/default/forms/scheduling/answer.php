<?php

// scheduling Poll 
$entity = elgg_extract('entity', $vars);

$answers = $entity->getVotesByUser();

$poll = $entity->getSlotsGroupedByDays();

$date_row = '<td class="empty"></td>';
$slot_row = '<td class="empty"></td>';
$poll_row = '<td></td>';
foreach ($poll as $day => $slots) {
    $col_span = count($slots);

    $date = date(elgg_echo('scheduling:date_format'), strtotime($day));
    $date_row .= "<td colspan=\"{$col_span}\">$date</td>";

    foreach ($slots as $timestamp => $slot) {
        $time = date('H:i', (int) $timestamp);
        $slot_row .= "<td>$time</td>";

        if ($entity->getPollType() == PollType::SIMPLE) {
            $poll_input = elgg_view('input/checkbox', array(
                'name' => $slot->guid,
                'value' => null,
                'checked' => $checked,
            ));
        } else {
            $valueCheck = $slot->getVoteValue(elgg_get_logged_in_user_entity());
            $poll_input = " <label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio' value='3'";
            $valueCheck == AwswerValue::YES ? $poll_input .= " checked='check'>" : $poll_input .= ">";
            $poll_input .= "<a title='" . elgg_echo("scheduling:form:anwser:title:yes") . "'>" . elgg_echo("scheduling:form:anwser:yes") . "</a><br>                        
                            </label>";
            $poll_input .= "<label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio' value='2'";
            $valueCheck == AwswerValue::MAYBE ? $poll_input .= " checked='check'>" : $poll_input .= ">";
            $poll_input .= "    <a title='" . elgg_echo("scheduling:form:anwser:title:maybe") . "'>" . elgg_echo("scheduling:form:anwser:maybe") . "</a><br>
                            </label>";
            $poll_input .= "<label>
                                <input type='radio' name='slot-" . $slot->guid . "' class='hiddenRadio' value='1'";
            $valueCheck == AwswerValue::NO ? $poll_input .= " checked='check'>" : $poll_input .= ">";
            $poll_input .= "    <a title='" . elgg_echo("scheduling:form:anwser:title:no") . "'>" . elgg_echo("scheduling:form:anwser:no") . "</a><br>
                            </label>";
        }

        $poll_row .= "<td>$poll_input</td>";
    }
}

$answer_rows = '';

foreach ($answers as $user_guid => $slots) {
    $user = get_entity($user_guid);
    $icon = elgg_view_entity_icon($user, 'tiny');

    $answer_row = "<td style=\"padding: 0;\">$icon</td>";
    foreach ($slots as $voteValue) {
        if ($voteValue == AwswerValue::YES) {
            $class = 'yes';
        } else if ($voteValue == AwswerValue::MAYBE) {
            $class = 'maybe';
        } else {
            $class = 'no';
        }
        $answer_row .= "<td class=\"$class\"></td>";
    }

    $answer_rows .= "<tr>$answer_row</tr>"; //*/
}//*/
// Add a row that shows the total amount of votes for each time slot
$answer_sums = $entity->getVoteCounts();
$sum_row = '<td class="empty"></td>';
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
