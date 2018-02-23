<?php

elgg_register_event_handler('init', 'system', 'scheduling_init');

/**
 * Initialize the plugin
 */
function scheduling_init() {
	$actions_path = elgg_get_plugins_path() . 'scheduling/actions/scheduling/';
	elgg_register_action('scheduling/save', $actions_path . 'save.php');
	elgg_register_action('scheduling/days', $actions_path . 'days.php');
	elgg_register_action('scheduling/slots', $actions_path . 'slots.php');
	elgg_register_action('scheduling/answer', $actions_path . 'answer.php');
	elgg_register_action('scheduling/delete', $actions_path . 'delete.php');

	elgg_register_library('elgg:scheduling', elgg_get_plugins_path() . 'scheduling/lib/scheduling.php');

	elgg_define_js('poll_js', [
		'src' => 'mod/scheduling/views/default/js/scheduling/poll.js',
		'deps' => ['jquery'],
		'exports' => 'poll_js',
	]);

	elgg_define_js('addslot_js', [
		'src' => 'mod/scheduling/views/default/js/scheduling/slot.js',
		'deps' => ['jquery'],
		'exports' => 'addslot_js',
	]);

	elgg_define_js('adddays_js', [
		'src' => 'mod/scheduling/views/default/js/scheduling/days.js',
		'deps' => ['jquery'],
		'exports' => 'adddays_js',
	]);

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

	// subtype
	add_subtype("object", "scheduling_poll_answer", "ElggSchedulingPollAnswer");
}

/**
 * Handle calls to page "scheduling"
 *
 * @param array $page
 */
function scheduling_page_handler($page) {
	elgg_load_library('elgg:scheduling');

	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
	];

	elgg_push_breadcrumb(elgg_echo('scheduling'));

	switch ($page_type) {
		case 'add':
			set_input('container_guid', $page[1]);
			echo elgg_view_resource('scheduling/save', $resource_vars);
			break;
		case 'edit':
			set_input('guid', $page[1]);
			echo elgg_view_resource('scheduling/save', $resource_vars);
			break;
		case 'addSlot':
			set_input('guid', $page[1]);
			echo elgg_view_resource('scheduling/slots', $resource_vars);
			break;
		case 'view':
			set_input('guid', $page[1]);
			echo elgg_view_resource('scheduling/view', $resource_vars);
			break;
		case 'days':
			set_input('guid', $page[1]);
			echo elgg_view_resource('scheduling/days', $resource_vars);
			break;
		case 'owner';
			$user = get_user_by_username($page[1]);
			if ($user) {
				set_input('container_guid', $user->guid);
			}
			echo elgg_view_resource('scheduling/all', $resource_vars);
			break;
		case 'group':
			if ($page[1]) {
				set_input('container_guid', $page[1]);
			}
			echo elgg_view_resource('scheduling/all', $resource_vars);
			break;
		default:
			echo elgg_view_resource('scheduling/all', $resource_vars);
			break;
	}

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
					'href' => "scheduling/addSlot/{$entity->guid}",
					'text' => elgg_echo('scheduling:edit:time'),
		));
	}

	return $menu;
}
