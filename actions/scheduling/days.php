<?php

elgg_make_sticky_form('scheduling');

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity->canEdit()) {
	register_error(elgg_echo('scheduling:error:cannot_edit'));
	forward();
}

$num_rows = get_input('num_rows');
$num_columns = get_input('num_columns');

for ($row = 0; $row <= $num_rows; $row++) {
	$date_timestamp = get_input("day{$row}");

	if (empty($date_timestamp)) {
		break;
	}

	$date = date('Y-m-d', $date_timestamp);
	register_error("The date is $date ($date_timestamp)");

	for ($column = 0; $column <= $num_columns; $column++) {
		$time = get_input("slot{$row}-{$column}");

		if (empty($time)) {
			continue;
		}

		if (preg_match("/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $time)) {
			register_error(elgg_echo('scheduling:error:invalid_format', array($time)));
		} else {
			register_error("Valid: $time");
		}
	}
}

forward(REFERER);
