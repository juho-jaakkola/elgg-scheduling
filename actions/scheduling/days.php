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

$poll = array();
for ($row = 0; $row < $num_rows; $row++) {
	$date_timestamp = get_input("day{$row}");

	if (empty($date_timestamp)) {
		break;
	}

	$date = date('Y-m-d', $date_timestamp);

	$slots = array();
	for ($column = 0; $column < $num_columns; $column++) {
		$time = get_input("slot{$row}-{$column}");

		if (empty($time)) {
			$slots[] = $time;
			continue;
		}

		if (!preg_match("/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $time)) {
			register_error(elgg_echo('scheduling:error:invalid_format', array($time)));
			forward(REFERER);
		}

		$slots[] = $time;
	}

	$poll[$date_timestamp] = $slots;
}

$entity->num_rows = $num_rows;
$entity->num_columns = $num_columns;
$entity->poll = serialize($poll);

forward($entity->getURL());
