<?php

/* * **************************************************************************
 * Copyright (C) 2017 Jade <http://www.jade.fr>
 * 
 * Benoit MOTTIN <benoitmottin@jade.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * ************************************************************************ */

$entity = elgg_extract('entity', $vars);

$rows = array();
// entity => ElggSchedulingPoll
$days = $entity->getSlotsGroupedByDays();

// generate columns
$date = gmdate('Y-m-d');
$current_hour = gmdate('G');
$num_columns = 4;

foreach ($days as $date => $slots) {
    foreach ($slots as $key => $slot) {

        $hour = $slot->title;
        $rows[$date][] = date("H:i", $hour);
    }
}

$index = 0;
$rows_html = '';

// foreach date show slot
foreach ($rows as $date => $slots) {

    $rows_html .= "<tr data-index='$index' id='row-" . $index . "' class='scheduling-row'>";
    $rows_html .= "<td class='scheduling-actions'>";
    $rows_html .= elgg_view('output/url', array(
        'text' => "",
        'href' => 'javascript:void(0);',
        'class' => 'scheduling-row-delete mll elgg-icon elgg-icon-trash',
        'title' => elgg_echo("scheduling:poll:delete:title")
    ));
    $rows_html .= elgg_view('output/url', array(
        'text' => "",
        'href' => 'javascript:void(0);',
        'class' => 'scheduling-row-copy elgg-icon elgg-icon-round-plus',
        'title' => elgg_echo("scheduling:poll:duplicate:title")
    ));
    $rows_html .= "</td>";
    $rows_html .= '<td class="scheduling-input-date td-scheduling-date">' . elgg_view('input/scheduling/date', array(
                'name' => "slots[$index][date]",
                'value' => $date,
    ));
    $rows_html .= "</td>";

    // Slot
    foreach ($slots as $slot) {
        $hour = roundToQuarterHour($slot);

        // Time 
        $rows_html .= '<td class="scheduling-input-time select-time-slot">' . elgg_view('input/scheduling/time', array(
                    'name' => "slots[$index][slot][]",
                    'value' => $hour,
                )) . '</td>';
    }

    // complete if necessary
    if (count($slots) < $num_columns) {


        for ($i = 1; $i <= $num_columns - count($slots); $i++) {

            $rows_html .= '<td class="scheduling-input-time select-time-slot">' . elgg_view('input/scheduling/time', array(
                        'name' => "slots[$index][slot][]",
                        'value' => '',
                    )) . '</td>';
        }
    }
    $rows_html .= '</tr>';
    $index++;
}



$headings = '<th class=""></th>';
$headings .= '<th class="scheduling-input-date"></th>';

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

$addrow_input .= elgg_view('output/url', array(
    'text' => elgg_echo('scheduling:row:copy'),
    'href' => 'javascript:void(0);',
    'class' => 'scheduling-row-copy',
        ));

$polltype_input = elgg_view("input/checkbox", array(
    'label' => elgg_echo('scheduling:poll:type:label'),
    'title' => elgg_echo('scheduling:poll:type:title'),
    'name' => 'pollType',
    'id' => 'pollType',
        ));


$submit_input = elgg_view('input/submit', array(
    'name' => elgg_echo('submit'),
        ));

$copy_first_input = "<a id='copyFirst' name='copyFirst'> " . elgg_echo('scheduling:poll:copy:first:line') . "</a>";

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
    <div>
        {$copy_first_input}
    </div>
    <div>
        {$polltype_input} 
   </div>
        
	<div class="elgg-foot">
		{$guid_input}{$container_guid_input}{$submit_input}
	</div>

FORM;


echo "  <script>       
            require(['addslot_js'], function() {
                window.addslot_js = require('addslot_js');
            });     
        </script>";

