<?php

elgg_make_sticky_form('scheduling');

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof ElggSchedulingPoll || !$entity->canEdit()) {
	register_error(elgg_echo('scheduling:error:cannot_edit'));
	forward();
}

$slots = array();
$input = (array) get_input('slots', array());

foreach ($input as $index => $date_info) {

	$date = $date_info['date'];
	$date_slots = $date_info['slot'];
	foreach ($date_slots as $slot) {
		if (empty($slot)) {
			continue;
		}
		$slots[] = strtotime("$date $slot");
	}
}

if ($entity->setSlots($slots)) {
	system_message(elgg_echo('scheduling:save:success'));
} else {
	register_error(elgg_echo('scheduling:save:error'));
}

elgg_clear_sticky_form('scheduling');

forward($entity->getURL());
