<?php

$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	$form_vars = scheduling_prepare_form_vars($entity);
} else {
	$form_vars = scheduling_prepare_form_vars();
}

$content = elgg_view_form('scheduling/save', array(), $form_vars);

$params = array(
	'title' => elgg_echo('scheduling'),
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page('title here', $body);