<?php

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof ElggSchedulingPoll || !$entity->canEdit()) {
	register_error(elgg_echo('scheduling:error:cannot_edit'));
	forward();
}

elgg_require_js('scheduling/table');

$form_vars = scheduling_prepare_form_vars($entity);
$form_vars['entity'] = $entity;

$content = '';
$content .= elgg_view('page/layouts/content/header', array('title' => $entity->title));
$content .= elgg_view_form('scheduling/days', array(), $form_vars);

$params = array(
	'title' => '',
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($entity->title, $body);
