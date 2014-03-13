<?php

$guid = get_input('guid');

$entity = get_entity($guid);

if (elgg_instanceof($entity, 'object', 'scheduling_poll')) {
	if (!$entity->canEdit()) {
		register_error(elgg_echo('scheduling:error:cannot_edit'));
		forward(REFERER);
	}
} else {
	$entity = new ElggObject();
	$entity->subtype = 'scheduling_poll';
}

$title = get_input('title');
$description = get_input('description');
$date_begin = get_input('date_begin');
$date_end = get_input('date_end');
$access_id = get_input('access_id');

$entity->access_id = $access_id;
$entity->title = $title;
$entity->description = $description;
$entity->date_begin = $date_begin;
$entity->date_end = $date_end;

if ($entity->save()) {
	system_message(elgg_echo('scheduling:save:success'));
} else {
	register_error(elgg_echo('scheduling:save:error'));
	forward(REFERER);
}

forward('scheduling/all');