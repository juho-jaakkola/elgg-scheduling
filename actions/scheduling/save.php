<?php

$guid = get_input('guid');

$entity = get_entity($guid);

$is_new = true;
if (elgg_instanceof($entity, 'object', 'scheduling_poll')) {
	if (!$entity->canEdit()) {
		register_error(elgg_echo('scheduling:error:cannot_edit'));
		forward(REFERER);
	}
	$is_new = false;
} else {
	$entity = new ElggObject();
	$entity->subtype = 'scheduling_poll';
	$entity->container_guid = get_input('container_guid');
}

$title = get_input('title');
$description = get_input('description');
$access_id = get_input('access_id');

$entity->access_id = $access_id;
$entity->title = $title;
$entity->description = $description;

if ($entity->save()) {
	system_message(elgg_echo('scheduling:save:success'));
} else {
	register_error(elgg_echo('scheduling:save:error'));
	forward(REFERER);
}

if ($is_new) {
	$forward_url = "scheduling/days/{$entity->guid}";
} else {
	$forward_url = $entity->getURL();
}

forward($forward_url);