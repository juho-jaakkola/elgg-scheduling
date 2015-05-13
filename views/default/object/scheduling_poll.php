<?php

$entity = elgg_extract('entity', $vars);
$full_view = elgg_extract('full_view', $vars);

// Do not show the metadata and controls in widget view
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

if ($full_view) {
	echo elgg_view('scheduling/view', $vars);
} else {
	$owner = $entity->getOwnerEntity();
	$container = $entity->getContainerEntity();
	$categories = elgg_view('output/categories', $vars);

	$owner_icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = elgg_view('output/url', array(
		'href' => "scheduling/owner/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	$date = elgg_view_friendly_time($entity->time_created);

	$subtitle = "$author_text $date $categories";

	$params = array(
		'entity' => $entity,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => elgg_get_excerpt($entity->description),
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
