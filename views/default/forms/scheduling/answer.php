<?php

$entity = elgg_extract('entity', $vars);

$poll = unserialize($entity->poll);

$date_row = '<td></td>';
$slot_row = '<td></td>';
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
foreach ($answers as $user_guid => $answer) {
	$user = get_entity($user_guid);
	$user_icon = elgg_view_entity_icon($user, 'tiny');

	$cells = "<td style=\"padding: 0;\">$user_icon</td>";
	foreach ($answer as $timestamp => $slots) {
		foreach ($slots as $slot) {
			$class = empty($slot) ? 'unselected' : 'selected';
			$cells .= "<td class=\"$class\"></td>";
		}
	}
	$answer_rows .= "<tr>$cells</tr>";
}

$submit_input = elgg_view('input/submit');
$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $entity->guid,
));

echo <<<FORM
	<table class="elgg-table mvm" id="elgg-table-scheduling-answer">
		<tr>$date_row</tr>
		<tr>$slot_row</tr>
		$answer_rows
		<tr>$poll_row</tr>
	</table>
	<div>
		$guid_input
		$submit_input
	</div>
FORM;
