<?php

$entity = elgg_extract('entity', $vars);

$poll = unserialize($entity->poll);

$date_row = '<td class="empty"></td>';
$slot_row = '<td class="empty"></td>';
$poll_row = '<td></td>';
foreach ($poll as $timestamp => $day) {
	$date = date(elgg_echo('scheduling:date_format'), $timestamp);
	$date_row .= "<td colspan=\"{$entity->num_columns}\">$date</td>";

	foreach ($day as $key => $slot) {
		$slot_row .= "<td>$slot</td>";

		$poll_input = elgg_view('input/checkbox', array(
			'name' => "{$timestamp}-{$key}",
			'value' => null,
		));

		$poll_row .= "<td>$poll_input</td>";
	}
}

$answers = $entity->getAnswers();

// Add answers, one row per user
$answer_rows = '';
$answer_sums = array();
foreach ($answers as $user_guid => $answer) {
	$user = get_entity($user_guid);
	$user_icon = elgg_view_entity_icon($user, 'tiny');

	$cells = "<td style=\"padding: 0;\">$user_icon</td>";
	foreach ($answer as $timestamp => $slots) {
		foreach ($slots as $key => $slot) {
			if (empty($slot)) {
				$class = 'unselected';
				$vote = 0;
			} else {
				$class = 'selected';
				$vote = 1;
			}

			// Add the vote to the sum of users who selected this time slot
			$answer_sums["{$timestamp}-{$key}"] += $vote;

			$cells .= "<td class=\"$class\"></td>";
		}
	}
	$answer_rows .= "<tr>$cells</tr>";
}

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
	<table class="elgg-table mvl" id="elgg-table-scheduling-answer">
		<tr>$date_row</tr>
		<tr>$slot_row</tr>
		$answer_rows
		<tr>$poll_row</tr>
		<tr>$sum_row</tr>
	</table>
	<div>
		$guid_input
		$submit_input
	</div>
FORM;
