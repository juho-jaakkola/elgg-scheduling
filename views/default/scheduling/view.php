<?php

$entity = elgg_extract('entity', $vars);

$begin = $entity->date_begin;
$end = $entity->date_end;

$seconds = $end - $begin;

$days = $entity->getDays();

foreach ($days as $day) {
	// TODO Add a hidden input for each of the days/hours?
	$form = elgg_view('input/hidden', array(
		'name' => 'todo',
	));
}

$body = "<p>$begin - $end</p><p>$days</p>";

$params = array(
	'entity' => $entity,
	'title' => false,
	//'metadata' => $metadata,
	//'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

echo elgg_view('object/elements/full', array(
	'summary' => $summary,
	'icon' => $owner_icon,
	'body' => $body,
));