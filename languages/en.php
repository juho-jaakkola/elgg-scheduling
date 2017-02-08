<?php

return array(
	'scheduling' => 'Scheduling',
	'scheduling:add' => 'Add a new poll',
	'item:object:scheduling_poll' => 'Scheduling polls',
	'item:object:scheduling_poll_slot' => 'Scheduling poll slots',
	'scheduling:date_format' => 'D n/j/Y',
	'scheduling:edit:time' => 'Edit times',
	'scheduling:slot:title' => 'Slot %s',
	'scheduling:column:add' => 'Add column',
	'scheduling:row:copy' => 'Duplicate row',
	'scheduling:row:delete' => 'Delete row',
	'scheduling:error:invalid_format' => 'Time needs to be in format HH:MM',
	'scheduling:add_day' => 'Add a new day',
	'scheduling:group:enable' => 'Enable group scheduling tool',

	'scheduling:owner_block' => 'Scheduling',
	'scheduling:owner_block:group' => 'Group scheduling',

	'scheduling:save:success' => 'Schedule poll saved',
	'scheduling:save:error' => 'Something went wrong. Check that the entered values are valid.',
	'scheduling:save:error:no:days' => 'You must select at least one date.',
	'scheduling:error:cannot_edit' => 'You are unauthorized to edit this content',
	'scheduling:delete:success' => 'Scheduling poll deleted',
	'scheduling:delete:error' => 'Deleting the scheduling poll failed',

    // form
    'scheduling:form:anwser:yes' => 'Yes',
    'scheduling:form:anwser:maybe' => '(Yes)',
    'scheduling:form:anwser:no' => 'No',
    'scheduling:form:anwser:title:yes' => 'Yes',
    'scheduling:form:anwser:title:maybe' => 'If necessary',
    'scheduling:form:anwser:title:no' => 'No',
    'scheduling:poll:type:label' => 'Advance Poll',
    'scheduling:poll:type:title' => 'Get 3 choices, Yes, Maybe, No',
    'scheduling:poll:picked:date:label' => 'Selected Dates:',
    'scheduling:poll:pick:date' => 'Pick some dates',
    'scheduling:poll:pick:date:instruction' => 'Just click on date in the calendar to add it. Just click on it in the list to delete this date.',
    'scheduling:poll:copy:first:line' => 'Copy all the first line value to others',
    'scheduling:form:answer:not:available' => 'Not available',
    
    
	// Notifications
	'scheduling:notify:publish:subject' => 'New scheduling poll',
	'scheduling:notify:publish:body' => '%s has created a new scheduling poll: "%s"

%s',
	'scheduling:notify:publish:summary' => '%s has created a new scheduling poll: %s',
	'scheduling:notify:update:subject' => 'Updated scheduling poll',
	'scheduling:notify:update:body' => '%s has updated the scheduling poll "%s" that you have answered earlier.

You should check if your answer needs to be updated:
%s',
	'scheduling:notify:update:summary' => '%s has updated the scheduling poll: %s',

	'river:create:object:scheduling_poll' => '%s created a new scheduling poll %s',
	
	// Breadcrumb
	'scheduling:breadcrumb:add:days' => 'Add days',
	'scheduling:breadcrumb:add:slots' => 'Add Slots',
	
);