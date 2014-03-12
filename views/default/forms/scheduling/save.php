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

$date_begin_label = elgg_echo('scheduling:date_begin');
$date_begin_input = elgg_view('input/date', array(
	'name' => 'date_begin',
	'value' => $vars['date_begin'],
	'timestamp' => true,
));

$date_end_label = elgg_echo('scheduling:date_end');
$date_end_input = elgg_view('input/date', array(
	'name' => 'date_end',
	'value' => $vars['date_end'],
	'timestamp' => true,
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
		<label>$date_begin_label</label>
		$date_begin_input
	</div>
	<div>
		<label>$date_end_label</label>
		$date_end_input
	</div>
	<div>
		<label>$access_label</label>
		$access_input
	</div>
	<div class="foot">
		$guid_input
		$submit_input
	</div>
FORM;

echo $form;
