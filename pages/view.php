<?php

$guid = get_input('guid');

elgg_entity_gatekeeper($guid);

$entity = get_entity($guid);

$title = $entity->title;

$view = elgg_view_entity($entity, array('full_view' => true));

$comments = elgg_view_comments($entity);

$params = array(
	'title' => $title,
	'content' => $view . $comments,
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
