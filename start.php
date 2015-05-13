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
	elgg_register_action('scheduling/delete', $actions_path . 'delete.php');

	elgg_register_library('scheduling', elgg_get_plugins_path() . 'scheduling/lib/scheduling.php');

	elgg_register_page_handler('scheduling', 'scheduling_page_handler');

	elgg_register_plugin_hook_handler('entity:url', 'object', 'scheduling_poll_url');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', '\Elgg\Scheduling\OwnerBlockMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'scheduling_entity_menu');

	// Notifications
	elgg_register_notification_event('object', 'scheduling_poll', array('publish', 'update'));
	elgg_register_plugin_hook_handler('prepare', 'notification:publish:object:scheduling_poll', '\Elgg\Scheduling\Notification::prepare');
	elgg_register_plugin_hook_handler('prepare', 'notification:update:object:scheduling_poll', '\Elgg\Scheduling\Notification::prepare');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\Elgg\Scheduling\Notification::subscribers');

	add_group_tool_option('scheduling', elgg_echo('scheduling:group:enable'));

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

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

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
		case 'owner';
			$user = get_user_by_username($page[1]);
			if ($user) {
				set_input('container_guid', $user->guid);
			}
			$page_path = 'all.php';
			break;
		case 'group':
			if ($page[1]) {
				set_input('container_guid', $page[1]);
			}
			$page_path = 'all.php';
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
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL
 */
function scheduling_poll_url($hook, $type, $url, $params) {
	$entity = $params['entity'];

	if (!$entity instanceof ElggSchedulingPoll) {
		return $url;
	}

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
	if (elgg_extract('handler', $params) !== 'scheduling') {
		return $menu;
	}

	$entity = $params['entity'];

	if ($entity->canEdit()) {
		$menu[] = ElggMenuItem::factory(array(
			'name' => 'scheduling_time',
			'href' => "scheduling/days/{$entity->guid}",
			'text' => elgg_echo('scheduling:edit:time'),
		));
	}

	return $menu;
}
