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

$('.possible-answer').on('click', function () {
    if ($('.possible-answer:checkbox:checked').length > 0) {
        $('#not-available').prop('checked', false);
    } else {
        $('#not-available').prop('checked', true);
    }

    if ($(this).prop('checked') === true) {
        $(this).closest('td').addClass('yes');
        $(this).closest('td').removeClass('no');
    } else {
        $(this).closest('td').addClass('no');
        $(this).closest('td').removeClass('yes');
    }
});

$(document).ready(function () {
    $('.possible-answer').each(function () {

        if ($(this).prop('checked') === true) {
            $(this).closest('td').addClass('yes');
            $(this).closest('td').removeClass('no');
        } else {
            $(this).closest('td').addClass('no');
            $(this).closest('td').removeClass('yes');
        }
    });

});

$('.hiddenRadio').on('click', function () {

    if ($(this).hasClass("answerYes")) {
        // get the first td parent
        $(this).closest('td').addClass('yes');
    } else if ($(this).hasClass("answerMaybe")) {
        $(this).closest('td').addClass('maybe');
    } else {
        $(this).closest('td').addClass('no');
    }
});