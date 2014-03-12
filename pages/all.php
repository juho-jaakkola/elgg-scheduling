<?php

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'scheduling_poll',
	'full_view' => false,
));

elgg_register_title_button();

$title = elgg_echo('scheduling');

$params = array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);