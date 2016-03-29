<?php

$entity = elgg_extract('entity', $vars);

$rows = array();
$days = $entity->getSlotsGroupedByDays();
$num_columns = 0;
if (!empty($days)) {
	foreach ($days as $date => $slots) {
		foreach ($slots as $slot) {
			$rows[$date][] = date("H:i", (int) $slot->title);
		}
		if (count($slots) > $num_columns) {
			$num_columns = count($slots);
		}
	}
} else {
	$date = gmdate('Y-m-d');
	$current_hour = gmdate('G');
	$num_columns = 4;
	for ($i = 1; $i <= $num_columns; $i++) {
		$hour = $current_hour + $i;
		if ($hour >= 24) {
			$hour -= 24;
		}
		$rows[$date][] = gmdate('H:i', strtotime("$hour:00") - strtotime($date));
	}
}

$index = 0;
$rows_html = '';
foreach ($rows as $date => $slots) {
	$rows_html .= "<tr data-index='$index'>";
	$rows_html .= '<td class="scheduling-input-date">' . elgg_view('input/scheduling/date', array(
				'name' => "slots[$index][date]",
				'value' => $date,
			)) . '</td>';
	foreach ($slots as $slot) {
		$rows_html .= '<td class="scheduling-input-time">' . elgg_view('input/scheduling/time', array(
					'name' => "slots[$index][slot][]",
					'value' => $slot,
				)) . '</td>';
	}

	if (count($slots) < $num_columns) {
		for ($i = 1; $i <= $num_columns - count($slots); $i++) {
			$rows_html .= '<td class="scheduling-input-time">' . elgg_view('input/scheduling/time', array(
						'name' => "slots[$index][slot][]",
						'value' => '',
					)) . '</td>';
		}
	}

	$rows_html .= '<td class="scheduling-actions">';
	$rows_html .= elgg_view('output/url', array(
		'text' => elgg_echo('scheduling:row:copy'),
		'href' => 'javascript:void(0);',
		'class' => 'scheduling-row-copy',
	));
	$rows_html .= elgg_view('output/url', array(
		'text' => elgg_echo('scheduling:row:delete'),
		'href' => 'javascript:void(0);',
		'class' => 'scheduling-row-delete mll',
	));
	$rows_html .= '</td>';

	$rows_html .= '</tr>';

	$index++;
}

$headings = '<th class="scheduling-input-date"></th>';
for ($i = 1; $i <= $num_columns; $i++) {
	$heading = elgg_echo('scheduling:slot:title', array($i));

	if ($i > 1) {
		$heading .= elgg_view_icon('delete-alt');
	}

	$headings .= '<th class="scheduling-input-time">' . $heading . '</th>';
}
$headings .= '<th class="scheduling-input-actions">' . elgg_view('output/url', array(
			'text' => elgg_echo('scheduling:column:add'),
			'href' => 'javascript:void(0);',
			'class' => 'scheduling-column-add',
		)) . '</th>';

$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $vars['guid'],
		));

$container_guid_input = elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['container_guid'],
		));

$submit_input = elgg_view('input/submit', array(
	'name' => elgg_echo('submit'),
		));

echo <<<FORM
	<table class="elgg-table-alt" id="elgg-table-scheduling">
		<thead>
			<tr>
				{$headings}
			</tr>
		</thead>
		<tbody>
			{$rows_html}
		</tbody>
	</table>
	<div class="elgg-foot">
		{$guid_input}{$container_guid_input}{$submit_input}
	</div>
FORM;
