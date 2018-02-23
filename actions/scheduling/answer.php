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
$notAvailableInput = get_input("not-available", false);

if ($notAvailableInput) {
	foreach ($slots as $slot) {
		$answer = AnswerValue::NO;
		$slot->vote($user, $answer, $slot->title);
	}
} else {
	foreach ($slots as $slot) {
		$answer = get_input('slot-' . $slot->guid);

		// for simple poll
		if ($answer) {
			if ($answer == 'on') {
				$answer = AnswerValue::YES;
			}
		} else {
			$answer = AnswerValue::NO;
		}

		if (empty($answer)) {
			$slot->removeVote($user);
		} else {
			$slot->vote($user, $answer, $slot->title);
		}
	}
}
