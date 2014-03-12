<?php

$guid = get_input('guid');

$entity = get_entity($guid);

$title = $entity->title;

$view = elgg_view_entity($entity, array('full_view' => true));

$params = array(
	'title' => $title,
	'content' => $view,
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
