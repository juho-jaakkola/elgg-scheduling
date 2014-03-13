<?php

$entity = elgg_extract('entity', $vars);

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
} else {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => 'scheduling',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$author_text = elgg_echo('byline', array($owner->name));
$date = elgg_view_friendly_time($entity->time_created);

$subtitle = "$author_text $date";

$params = array(
	'entity' => $entity,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$body = elgg_view('output/longtext', array('value' => $entity->description));
$body .= elgg_view_form('scheduling/answer', array(), array('entity' => $entity));

echo elgg_view('object/elements/full', array(
	'summary' => $summary,
	'icon' => $owner_icon,
	'body' => $body,
));
