<?php

namespace Elgg\Scheduling;

use ElggMenuItem;
use ElggUser;

class OwnerBlockMenu {

	/**
	 * Add menu item to the ownerblock
	 */
	public static function register ($hook, $type, $return, $params) {
		$entity = $params['entity'];

		if ($entity instanceof ElggUser) {
			$url = "scheduling/owner/{$entity->username}";
			$return[] = new ElggMenuItem('scheduling', elgg_echo('scheduling:owner_block'), $url);
		} else {
			if ($entity->scheduling_enable != "no") {
				$url = "scheduling/group/{$entity->guid}/all";
				$return[] = new ElggMenuItem('scheduling', elgg_echo('scheduling:owner_block:group'), $url);
			}
		}

		return $return;
	}
}
