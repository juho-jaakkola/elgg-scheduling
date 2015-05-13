<?php

$entity = elgg_extract('entity', $vars);

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'value' => $vars['title'],
));

$description_label = elgg_echo('description');
$description_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'value' => $vars['description'],
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'value' => $vars['access_id']
));

$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $vars['guid'],
));

$container_guid_input = elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => elgg_get_page_owner_guid(),
));

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit',
	'value' => elgg_echo('save'),
));

$form = <<<FORM
	<div>
		<label>$title_label</label>
		$title_input
	</div>
	<div>
		<label>$description_label</label>
		$description_input
	</div>
	<div>
		<label>$access_label</label>
		$access_input
	</div>
	<div class="foot">
		$guid_input
		$container_guid_input
		$submit_input
	</div>
FORM;

echo $form;
