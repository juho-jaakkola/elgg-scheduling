<?php

$entity = elgg_extract('entity', $vars);

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

		$poll_input = elgg_view('input/checkbox', array(
			'name' => $slot->guid,
			'value' => null,
		));

		$poll_row .= "<td>$poll_input</td>";
	}
}

$answers = $entity->getVotesByUser();

$answer_rows = '';
foreach ($answers as $user_guid => $slots) {
	$user = get_entity($user_guid);
	$icon = elgg_view_entity_icon($user, 'tiny');

	$answer_row = "<td style=\"padding: 0;\">$icon</td>";
	foreach ($slots as $slot) {
		if ($slot) {
			$class = 'selected';
		} else {
			$class = 'unselected';
		}

		$answer_row .= "<td class=\"$class\"></td>";
	}

	$answer_rows .= "<tr>$answer_row</tr>";
}

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
