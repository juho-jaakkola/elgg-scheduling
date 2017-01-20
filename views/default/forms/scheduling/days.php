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
echo '<p>Pick some Date:</p>
<div id="datepicker" style="width:300px; display:inline-block"></div>


';


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
?>


<script>

    $("#datepicker").datepicker({
        onSelect: function (dateText) {
            var dateSelected = this.value;

            // check if element is checked

            // add class selected if not already

            // add date to the list
            $("#date-selected").find("ul").append("<input type='hidden' name='poll-days[]' id='poll-days' value='" + dateSelected + "'><li>" + dateSelected + "</li>");

            // else remove it




            //

        }


    });

</script>

<script>
    $(function () {
        $("#datepicker").datepicker();
    });
</script>