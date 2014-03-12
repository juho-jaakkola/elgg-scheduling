<?php

$entity = elgg_extract('entity', $vars);

$num_rows = $vars['num_rows'];
$num_cols = $vars['num_columns'];

$headings = '<th></th>';
for ($heading = 0; $heading < $num_cols; $heading++) {
	$text = elgg_echo('scheduling:slot:title', array($heading));
	$headings .= "<th>$text</th>";
}

for ($day = 0; $day < $num_rows; $day++) {
	$timestampt = $entity->getTimeFromDaynumber($day);

	$date = date(elgg_echo('scheduling:date_format'), $timestampt);

	$day_number_input = elgg_view('input/hidden', array(
		'name' => "day{$day}",
		'value' => $timestampt,
	));

	$row = "<td>{$date}{$day_number_input}</td>";
	for ($slot = 0; $slot < $num_cols; $slot++) {
		$slot_name = "slot{$day}-{$slot}";
		$field = elgg_view('input/text', array(
			'name' => $slot_name,
			'value' => $vars[$slot_name],
			'class' => 'scheduling-slot',
			'data-day' => $day,
			'data-slot' => $slot,
		));

		$row .= "<td>$field</td>";
	}

	$rows .= "<tr>$row</tr>";
}

$add_day_label = elgg_echo('scheduling:add_day');
$add_day_input = elgg_view('input/text', array(
	'name' => elgg_echo('date'),
	'id' => 'new_date',
));

$num_rows_input = elgg_view('input/hidden', array(
	'name' => 'num_rows',
	'id' => 'num_rows',
	'value' => $vars['num_rows'],
));

$num_columns_input = elgg_view('input/hidden', array(
	'name' => 'num_columns',
	'id' => 'num_columns',
	'value' => $vars['num_columns'],
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
		$num_rows_input
		$num_columns_input
		$guid_input
		$container_guid_input
		$submit_input
	</div>
FORM;
