<?php

$guid = get_input('guid');
$entity = get_entity($guid);

if (!elgg_instanceof($entity, 'object', 'scheduling_poll')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$poll = unserialize($entity->poll);

$times = array();
foreach ($poll as $timestamp => $slots) {
	foreach ($slots as $key => $slot) {
		$answer = get_input("{$timestamp}-{$key}");
		$times[$timestamp][$key] = !empty($answer);
	}
}

// Remove existing answers from this user
$options = array(
	'annotation_owner_guid' => $entity->guid,
	'entity_guid' => elgg_get_logged_in_user_guid(),
	'limit' => 0,
	'annotation_name' => 'scheduling_poll_answer',
);
elgg_delete_annotations($options);

// Add a new answer
$success = $entity->annotate('scheduling_poll_answer', serialize($times), $entity->access_id, elgg_get_logged_in_user_guid());

if ($success) {
	system_message(elgg_echo('scheduling:answer:success'));
	forward($entity->getURL());
} else {
	register_error(elgg_echo('scheduling:answer:error'));
	forward(REFERER);
}
