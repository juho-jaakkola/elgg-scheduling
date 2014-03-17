<?php

$guid = get_input('guid');
$entity = get_entity($guid);

if ($entity instanceof ElggSchedulingPoll && $entity->canEdit()) {
	if ($entity->delete()) {
		system_message(elgg_echo('scheduling:delete:success'));
		forward('scheduling/all');
	} else {
		register_error(elgg_echo('scheduling:delete:error'));
	}
} else {
	register_error(elgg_echo('actionunauthorized'));
}

forward(REFERER);
