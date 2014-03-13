<?php

elgg_register_event_handler('init', 'system', 'scheduling_init');

/**
 * Initialize the plugin
 */
function scheduling_init() {
	$actions_path = elgg_get_plugins_path() . 'scheduling/actions/scheduling/';
	elgg_register_action('scheduling/save', $actions_path . 'save.php');
	elgg_register_action('scheduling/days', $actions_path . 'days.php');
	elgg_register_action('scheduling/answer', $actions_path . 'answer.php');

	elgg_register_library('scheduling', elgg_get_plugins_path() . 'scheduling/lib/scheduling.php');

	elgg_register_page_handler('scheduling', 'scheduling_page_handler');

	elgg_register_entity_url_handler('object', 'scheduling_poll', 'scheduling_poll_url');

	elgg_register_plugin_hook_handler('register', 'menu:entity', 'scheduling_entity_menu');

	elgg_extend_view('css/elgg', 'scheduling/css');

	elgg_register_menu_item('site', array(
		'name' => 'scheduling',
		'text' => elgg_echo('scheduling'),
		'href' => 'scheduling',
	));

	elgg_register_js('elgg.scheduling', 'mod/scheduling/views/default/js/scheduling/table.js');
	elgg_register_js('date.format', 'mod/scheduling/vendors/dateformat/date.format.js');
}

/**
 * Handle calls to page "scheduling"
 *
 * @param array $page
 */
function scheduling_page_handler($page) {
	elgg_load_library('scheduling');

	elgg_push_breadcrumb(elgg_echo('scheduling'));

	$base_path = elgg_get_plugins_path() . 'scheduling/pages/';

	switch ($page[0]) {
		case 'add':
			set_input('container_guid', $page[1]);
			$page_path = 'save.php';
			break;
		case 'edit':
			set_input('guid', $page[1]);
			$page_path = 'save.php';
			break;
		case 'view':
			set_input('guid', $page[1]);
			$page_path = 'view.php';
			break;
		case 'days':
			set_input('guid', $page[1]);
			$page_path = 'days.php';
			break;
		default:
			$page_path = 'all.php';
			break;
	}

	include_once($base_path . $page_path);

	return true;
}

/**
 * Populates the ->getUrl() method
 *
 * @param ElggEntity $entity
 * @return string URL
 */
function scheduling_poll_url($entity) {
	$title = elgg_get_friendly_title($entity->name);

	return "scheduling/view/{$entity->guid}/$title";
}

/**
 * Set up entity menu items
 *
 * @param string         $hook
 * @param string         $type
 * @param array          $menu
 * @param ElggMenuItem[] $params
 * @return ElggMenuItem[] $menu
 */
function scheduling_entity_menu($hook, $type, $menu, $params) {
	if ($params['handler'] !== 'scheduling') {
		return $menu;
	}

	$entity = $params['entity'];

	if ($entity->canEdit()) {
		$menu[] = ElggMenuItem::factory(array(
			'name' => 'scheduling_time',
			//'href' => "scheduling/edit/{$entity->guid}/time",
			'href' => "scheduling/days/{$entity->guid}",
			'text' => elgg_echo('scheduling:edit:time'),
		));
	}

	return $menu;
}
