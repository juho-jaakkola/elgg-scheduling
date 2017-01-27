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


$guid_input = elgg_view('input/hidden', array(
    'name' => 'guid',
    'value' => $vars['guid'],
        ));

$submit_input = elgg_view('input/submit', array(
    'name' => elgg_echo('submit'),
        ));

// Add picker for date multi selection
/* echo '<p>Pick some Date:</p>
  <div id="datepicker" style="width:300px; display:inline-block"></div>';// */

echo "<p><label>" . elgg_echo("scheduling:poll:pick:date") . "</label></p>";


echo "<div id='scheduling-datepicker' data-gueule='{}'></div>"; //*/
// show selected date on the right column
// onclick this event get class "selected" so he can't be 

echo <<<FORM
	
    <form>
        <div id='date-selected' style='display:inline-block'>
            <ul>
                
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


