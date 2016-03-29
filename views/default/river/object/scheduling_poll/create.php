<?php
/**
 * River view
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => elgg_get_excerpt($object->description),
));
