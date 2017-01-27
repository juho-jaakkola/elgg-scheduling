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

$("#copyFirst").on("click", function () {

    var allHours = new Array();
    $("#row-0").find('.scheduling-input-time select').each(function () {
        allHours.push(this.value);
    });

    $("#elgg-table-scheduling").find('.scheduling-row ').each(function () {
        var i = 0;
        $(this).find(".scheduling-input-time select").each(function () {
            this.value = allHours[i];
            i++;
        });
    });
});
