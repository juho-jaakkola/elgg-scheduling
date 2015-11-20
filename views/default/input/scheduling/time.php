<?php

/**
 * Time input
 * @uses $vars['interval'] Interval between options
 * @uses $vars['format'] Date format to apply
 */
$vars['options_values'] = array('' => '');
$interval = (int) elgg_extract('interval', $vars, 900);
$format = elgg_extract('format', $vars, "H:i");
$options = range(0, 86400, $interval);
foreach ($options as $option) {
	$time = gmdate($format, $option);
	$vars['options_values'][$time] = $time;
}
echo elgg_view('input/dropdown', $vars);