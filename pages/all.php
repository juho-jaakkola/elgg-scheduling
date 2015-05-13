<?php

$options = array(
	'type' => 'object',
	'subtype' => 'scheduling_poll',
	'full_view' => false,
);

$container_guid = get_input('container_guid');

if ($container_guid) {
	$options['container_guid'] = $container_guid;
}

$content = elgg_list_entities($options);

elgg_register_title_button();

$title = elgg_echo('scheduling');

$params = array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);