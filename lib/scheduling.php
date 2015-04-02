<?php

/**
 * Pull together variables for the save form
 *
 * @param ElggEntity $schedule
 * @return array $values
 */
function scheduling_prepare_form_vars(ElggEntity $schedule = null) {
	$values = array(
		'guid' => 0,
		'title' => '',
		'description' => '',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'container_guid' => 0,
		'access_id' => ACCESS_PUBLIC,
	);

	if ($schedule) {
		foreach ($values as $field => $value) {
			if (isset($schedule->$field)) {
				$values[$field] = $schedule->$field;
			}
		}
	}

	if (elgg_is_sticky_form('scheduling')) {
		$sticky_values = elgg_get_sticky_values('scheduling');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('scheduling');

	return $values;
}
