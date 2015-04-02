<?php

$entity = elgg_extract('entity', $vars);

$days = $entity->getSlotsGroupedByDays();

$num_rows = $days ? count($days) : 1;
$num_cols = count(reset($days)) ? count(reset($days)) : 1;

$headings = '<th></th>';
for ($heading = 0; $heading < $num_cols; $heading++) {
	$text = elgg_echo('scheduling:slot:title', array($heading));
	$headings .= "<th>$text</th>";
}

$current_day = 0;

$rows = '';
foreach ($days as $iso_date => $slots) {
	// Convert YYYY-MM-DD into a timestamp
	$timestamp = strtotime($iso_date);

	$date = date(elgg_echo('scheduling:date_format'), $timestamp);

	$day_number_input = elgg_view('input/hidden', array(
		'name' => "day{$current_day}",
		'value' => $timestamp,
	));

	$row = "<td>{$date}{$day_number_input}</td>";

	$current_slot = 0;
	foreach ($slots as $slot) {
		$slot_name = "slot{$current_day}-{$current_slot}";

		$field = elgg_view('input/text', array(
			'name' => $slot_name,
			'value' => date('H:i', $slot->title),
			'class' => 'scheduling-slot',
			'data-day' => $current_day,
			'data-slot' => $current_slot,
		));

		$row .= "<td>$field</td>";

		$current_slot++;
	}

	$rows .= "<tr id=\"$timestamp\">$row</tr>";

	$current_day++;
}

$add_day_label = elgg_echo('scheduling:add_day');
$add_day_input = elgg_view('input/text', array(
	'name' => elgg_echo('date'),
	'id' => 'new_date',
));

// This field is populated using javascript
$slots_input = elgg_view('input/hidden', array(
	'name' => 'slots',
	'id' => 'scheduling-slots',
	'value' => null,
));

$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $vars['guid'],
));

$container_guid_input = elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['container_guid'],
));

$submit_input = elgg_view('input/submit', array(
	'name' => elgg_echo('submit'),
));

echo <<<FORM
	<table class="elgg-table" id="elgg-table-scheduling"><tr>{$headings}</tr>{$rows}</table>
	<div>
		<label>$add_day_label</label>
		$add_day_input
	</div>
	<div>
		$slots_input
		$guid_input
		$container_guid_input
		$submit_input
	</div>
FORM;
