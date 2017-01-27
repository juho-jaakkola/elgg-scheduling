/* ***************************************************************************
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


$(function () {
    $("#scheduling-datepicker").datepicker();
    dayChoose = new Array();
    dateKey = 0;
});

$("#scheduling-datepicker").datepicker({

    onSelect: function () {
        var dateSelected = this.value;
        var flag = true;
        
        // if there is some date already selected
        if (dayChoose.length > 0) {
            for (i = 0; i < dayChoose.length; i++) {
                var myDay = dayChoose[i];
                var currentDate = myDay["dateSelected"];
                if (currentDate === dateSelected) {
                    flag = false;
                }
            }
        }

        if (flag) {
            dayChoose.push({dateKey: dateKey, dateSelected: dateSelected});
            $("#date-selected").find("ul").append("<li id='list-" + dateKey + "' class='listElm'><input type='hidden' name='poll-days[]' id='poll-days-" + dateKey + "' value='" + dateSelected + "'>" + dateSelected + "</li>");
            dateKey++;
        }
    }
});

// delete the selected date
$(document).on('click', '.listElm', function (event) {
    id2del = event.target.id;
    id2delete = "#" + id2del;

    var dateSelected = $("#poll-days-" + id2del.replace("list-", '')).val();

    $(id2delete).remove();
    dayChoose.pop(dateSelected);
});

