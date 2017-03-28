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

$guid = get_input('guid');
$entity = get_entity($guid);

elgg_push_breadcrumb(elgg_echo('scheduling:breadcrumb:add:days'), "scheduling/days/" . $entity->guid);
elgg_push_breadcrumb(elgg_echo('scheduling:breadcrumb:add:slots'));

if (!$entity instanceof ElggSchedulingPoll || !$entity->canEdit()) {
	register_error(elgg_echo('scheduling:error:cannot_edit'));
	forward();
}

elgg_require_js('scheduling/table');

$form_vars = scheduling_prepare_form_vars($entity);
$form_vars['entity'] = $entity;

$content = '';
$content .= elgg_view('page/layouts/content/header', array('title' => $entity->title));
$content .= elgg_view_form('scheduling/slots', array(), $form_vars);

$params = array(
	'title' => '',
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($entity->title, $body);
