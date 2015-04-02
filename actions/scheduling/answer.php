<?php
/**
 * Saves users answer to a scheduling poll
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof ElggSchedulingPoll) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

$slots = $entity->getSlots();

foreach ($slots as $slot) {
	$answer = get_input($slot->guid);

	if (empty($answer)) {
		$slot->removeVote($user);
	} else {
		$slot->vote($user);
	}
}
