<?php

/**
 *
 */
class ElggSchedulingPoll extends ElggObject {

	private $slots = array();

	/**
	 *
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'scheduling_poll';
	}

	/**
	 * Makes sure access_id of the poll slots matches access_id of the poll
	 *
	 * @return boolean
	 */
	public function save() {
		$success = parent::save();

		if (!$success) {
			return false;
		}

		// Update slot access_ids if necessary
		foreach ($this->getSlots() as $slot) {
			if ($slot->access_id === $this->access_id) {
				// They're already the same so no need to continue
				break;
			}

			$slot->access_id = $this->access_id;
			$slot->save();
		}

		return true;
	}

	/**
	 * Get all the time slots saved for this poll
	 *
	 * @return array $slots
	 */
	public function getSlots() {
		if (!empty($this->slots)) {
			return $this->slots;
		}

		$slots = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'scheduling_poll_slot',
			'container_guid' => $this->guid,
			'limit' => 0,
		));

		foreach ($slots as $slot) {
			$this->slots[$slot->title] = $slot;
		}

		// Sort by the timestamp (object title)
		ksort($this->slots);

		return $this->slots;
	}

	/**
	 * Get slots grouped by poll days
	 *
	 * @return array $grouped_slots
	 */
	public function getSlotsGroupedByDays() {
		$slots = $this->getSlots();

		$grouped_slots = array();
		foreach ($slots as $slot) {
			$day = date('Y-m-d', $slot->title);

			$grouped_slots[$day][$slot->title] = $slot;
		}

		return $grouped_slots;
	}

	/**
	 * Save time slot options
	 *
	 * @param array $slots Array of timestamps
	 * @return bool Were all slots saved succesfully?
	 */
	public function setSlots($slots) {
		$this->getSlots();

		if ($this->slots) {
			$event = 'update';
		} else {
			// No slots were found, so we assume this is a new poll
			$event = 'publish';
		}

		$success = true;

		// Delete the slots that were removed from the timetable
		foreach ($this->slots as $existing_slot) {
			$existing_timestamp = $existing_slot->title;

			if (!in_array($existing_timestamp, $slots)) {
				$success = $existing_slot->delete();

				if ($success) {
					unset($this->slots[$existing_timestamp]);
				} else {
					$success = false;
				}
			}
		}

		// Add new slots
		foreach ($slots as $slot) {
			foreach ($this->slots as $existing_slot) {
				if ($slot == $existing_slot->title) {
					// This slot already exists. Continue to next one.
					continue 2;
				}
			}

			$new_slot = new ElggSchedulingPollSlot();
			$new_slot->title = $slot;
			$new_slot->container_guid = $this->guid;
			$new_slot->access_id = $this->access_id;

			if (!$new_slot->save()) {
				$success = false;
			}
		}

		// We don't want to notify about the create/update event of a
		// scheduling_poll object because one may exist without any options.
		// So we trigger an event manually once we're sure options exist.
		elgg_trigger_event($event, 'scheduling_poll', $this);

		return $success;
	}

	/**
	 * Get all votes as unordered list
	 *
	 * @return ElggAnnotation[]
	 */
	private function getVotes() {
		$slots = $this->getSlots();

		$guids = array();
		foreach ($slots as $slot) {
			$guids[] = $slot->guid;
		}

		$options = array(
			'guids' => $guids,
			'limit' => 0,
			'annotation_name' => 'scheduling_poll_answer',
		);

		return elgg_get_annotations($options);
	}

	/**
	 * Get answers
	 *
	 * @return array $answers
	 */
	public function getVotesByUser() {
		$annotations = $this->getVotes();
		$slots = $this->getSlots();

		$votes = array();
		foreach ($annotations as $annotation) {
			$votes[$annotation->owner_guid][$annotation->entity_guid] = true;
		}

		$votes_by_user = array();
		foreach ($votes as $user_guid => $slot_guid) {
			foreach ($slots as $slot) {
				if (isset($votes[$user_guid][$slot->guid])) {
					$vote = true;
				} else {
					$vote = false;
				}

				$votes_by_user[$user_guid][$slot->guid] = $vote;
			}
		}

		return $votes_by_user;
	}

	/**
	 *
	 */
	public function getVoteCounts() {
		$votes = $this->getVotes();
		$slots = $this->getSlots();

		$counts = array();
		foreach ($slots as $slot) {
			$vote = 0;
			foreach ($votes as $user_vote) {
				if ($user_vote->entity_guid == $slot->guid) {
					$vote++;
				}
			}
			$counts[$slot->guid] = $vote;
		}

		return $counts;
	}
}
