<?php

namespace Elgg\Scheduling;

class Notification {

	/**
	 * Prepares a notification message about a scheduling poll
	 *
	 * @param string $hook         Hook name
	 * @param string $type         Hook type
	 * @param object $notification The notification to prepare
	 * @param array  $params       Hook parameters
	 * @return object
	 */
	public static function prepare($hook, $type, $notification, $params) {
		$event = elgg_extract('event', $params);
		$action = $event->getAction();
		$entity = $params['event']->getObject();
		$owner = $params['event']->getActor();
		$language = $params['language'];

		$notification->subject = elgg_echo("scheduling:notify:{$action}:subject", array($entity->title), $language);
		$notification->body = elgg_echo("scheduling:notify:{$action}:body", array(
			$owner->name,
			$entity->title,
			$entity->getURL()
		), $language);
		$notification->summary = elgg_echo("scheduling:notify:{$action}:summary", array($owner->name, $entity->title), $language);

		return $notification;
	}

	/**
	 * Get notification preferences of users who have answered the poll
	 *
	 * The poll contents have changed so we must notify the people
	 * who had answered before the changes took place.
	 *
	 * @param string $hook          'get'
	 * @param string $type          'subscriptions'
	 * @param array  $subscriptions Array containing subscriptions in the form
	 *                              <user guid> => array('email', 'site', etc.)
	 * @param array  $params        Hook parameters
	 * @return array
	 */
	public static function subscribers($hook, $type, $subscriptions, $params) {
		$poll = $params['event']->getObject();

		if (!$poll instanceof \ElggSchedulingPoll) {
			return $subscriptions;
		}

		$subscriptions = array();

		$voters = array_keys($poll->getVotesByUser());

		if (empty($voters)) {
			// There's no one to notify
			return $subscriptions;
		}

		// Get all available notification methods
		$methods = _elgg_services()->notifications->getMethods();

		// Get all users who have voted
		$users = elgg_get_entities(array(
			'type' => 'user',
			'guids' => $voters,
			'limit' => 0,
		));

		// Personal notification settings are saved into a metadata
		// called notification:method:{$method}. Go through the users
		// and check which methods have been enabled for each user.
		foreach ($users as $user) {
			foreach ($methods as $method) {
				$meta_name = "notification:method:{$method}";

				if ((bool) $user->$meta_name) {
					$subscriptions[$user->guid][] = $method;
				}
			}
		}

		return $subscriptions;
	}
}