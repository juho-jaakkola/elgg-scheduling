<?php

if (get_subtype_id('object', 'scheduling_poll')) {
	update_subtype('object', 'scheduling_poll', 'ElggSchedulingPoll');
} else {
	add_subtype('object', 'scheduling_poll', 'ElggSchedulingPoll');
}

if (get_subtype_id('object', 'scheduling_poll_slot')) {
	update_subtype('object', 'scheduling_poll_slot', 'ElggSchedulingPollSlot');
} else {
	add_subtype('object', 'scheduling_poll_slot', 'ElggSchedulingPollSlot');
}