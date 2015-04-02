<?php

elgg_make_sticky_form('scheduling');

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof ElggSchedulingPoll || !$entity->canEdit()) {
	register_error(elgg_echo('scheduling:error:cannot_edit'));
	forward();
}

$slots = explode(',', get_input('slots'));

if ($entity->setSlots($slots)) {
	system_message(elgg_echo('scheduling:save:success'));
} else {
	register_error(elgg_echo('scheduling:save:error'));
}

elgg_clear_sticky_form('scheduling');

forward($entity->getURL());
