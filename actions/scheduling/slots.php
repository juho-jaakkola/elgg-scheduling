<?php

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

elgg_make_sticky_form('scheduling');

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof ElggSchedulingPoll || !$entity->canEdit()) {
    register_error(elgg_echo('scheduling:error:cannot_edit'));
    forward();
}

$slots = array();
$input = (array) get_input('slots', array());

// type of poll, simple or advanced (2 or 3 answer possible)
$pollType = get_input('pollType', false);

if ($pollType == 'on') {
    $entity->setPollType(PollType::ADVANCE);
} else {
    $entity->setPollType(PollType::SIMPLE);
}

foreach ($input as $index => $date_info) {

    $date = $date_info['date'];
    $date_slots = $date_info['slot'];
    foreach ($date_slots as $slot) {
        if (empty($slot)) {
            continue;
        }
        $slots[] = strtotime("$date $slot");
    }
}

if ($entity->setSlots($slots)) {
    system_message(elgg_echo('scheduling:save:success'));
} else {
    register_error(elgg_echo('scheduling:save:error'));
}

elgg_clear_sticky_form('scheduling');

forward($entity->getURL());
