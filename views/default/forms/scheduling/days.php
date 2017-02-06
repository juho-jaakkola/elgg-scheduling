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

/* elgg_get_entities(array(
  'type' =>'object',
  'subtype' => 'scheduling_poll_slot',

  ));// */

//$slots = elgg_get_entities(array(
//    'type' => 'object',
//    'subtype' => 'scheduling_poll_slot',
//    'container_guid' => $entity->guid,
//    'limit' => 0,
//    ));


$slots = $entity->getSlotsGroupedByDays("m/d/Y");
$slots1 = $entity->getSlotsGroupedByDays();
/*
  elgg_dump("-----slots-------");
  elgg_dump($slots);
  elgg_dump("---------------------");
 */


//<li id='list-" + dateKey + "' class='listElm'><input type='hidden' name='poll-days[]' id='poll-days-" + dateKey + "' value='" + dateSelected + "'>" + dateSelected + "</li>
$days = "";
$dateKey = 0;
foreach ($slots as $day => $slot) {
    echo $day . "<br>";
    $days .= "<li id='list-" . $dateKey . "' class='listElm'><input type='hidden' class='elemDay' name='poll-days[]' id='poll-days-" . $dateKey . "' value='" . $day . "'>" . $day . "</li>";

    $dateKey ++;
}

foreach ($slots1 as $day => $slot) {
    echo $day . "<br>";
}

$guid_input = elgg_view('input/hidden', array(
    'name' => 'guid',
    'value' => $vars['guid'],
        ));

$submit_input = elgg_view('input/submit', array(
    'name' => elgg_echo('submit'),
        ));

$labelPickedDate = elgg_echo("scheduling:poll:picked:date:label");

// Add picker for date multi selection
echo "<p><label>" . elgg_echo("scheduling:poll:pick:date") . "</label></p>";
echo "<p><label>" . elgg_echo("scheduling:poll:pick:date:instruction") . "</label></p>";

echo "<div id='scheduling-datepicker'></div>";


// show selected date on the right column
// onclick this event get class "selected" so he can't be 

echo <<<FORM
	
    <form>
        <div id='date-selected' style='display:inline-block'>
            <label> {$labelPickedDate} </label>
            <ul>
                {$days}
            </ul>  
        </div>
        <div class="elgg-foot">
            {$guid_input}
            {$submit_input}
        </div>
    <form>
    
FORM;

echo "  <script>
            require(['adddays_js'], function() {                
                window.adddays_js = require('adddays_js');
            });     
        </script>";


