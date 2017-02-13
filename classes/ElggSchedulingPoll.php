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

	public function getDaysOfSlots($slots, $format = 'Y-m-d') {

		$dates = array();


		foreach ($slots as $slot) {
			$dates[] = date($format, $slot);
		}

		return $dates;
	}

	/**
	 * Get slots grouped by poll days
	 *
	 * @return array $grouped_slots
	 */
	public function getSlotsGroupedByDays($format = 'Y-m-d') {
		$slots = $this->getSlots();

		$grouped_slots = array();
		foreach ($slots as $slot) {
			$day = date($format, $slot->title);

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
	public function setSlots($slots, $guids = array()) {
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

			if ($event === 'update') {
				$users = $this->getVotesByUser();

				foreach ($users as $guid => $u) {
					$user = get_entity($guid);
					$new_slot->vote($user, AnswerValue::UNDEFINED, $new_slot->title);
				}
			}
		}

		if ($event === 'publish') {
			elgg_create_river_item(array(
				'view' => 'river/object/scheduling_poll/create',
				'action_type' => 'create',
				'subject_guid' => $this->owner_guid,
				'object_guid' => $this->guid,
			));
		}

		// We don't want to notify about the create/update event of a
		// scheduling_poll object because one may exist without any options.
		// So we trigger an event manually once we're sure options exist.
		elgg_trigger_event($event, 'object', $this);

		return $success;
	}

	public function setSlotsDays($slots, $format = 'Y-m-d') {
		$this->getSlots();

		if ($this->slots) {
			$event = 'update';
		} 
		
		// convert all slot in date for checking
		$existing_dates = $this->getSlotsGroupedByDays($format);
		$new_dates = $this->getDaysOfSlots($slots, $format);

		$success = true;

		// Delete the slots that were removed from the timetable
		foreach ($existing_dates as $key => $slot) {
			// compare it with others 
			// delete associated slot with the day
			if (!in_array($key, $new_dates)) {
				foreach ($slot as $ts => $sl) {
					$success = $sl->delete();
					if ($success) {
						unset($this->slots[$ts]);
					} else {
						$success = false;
					}
				}
			}

			if (in_array($key, $new_dates)) {
				foreach ($slot as $ts => $sl) {
					// convert to date
					$date2check = date($format, $ts);
					// convert this date to timestamp to check if date doesn't exist
					$ts2check = strtotime($date2check);
					$key2del = array_keys($slots, $ts2check);
					unset($slots[$key2del[0]]);
				}
			}
		}

		//$ia = elgg_set_ignore_access(true);
		// Add new slots        
		foreach ($slots as $slot) {

			$new_slot = new ElggSchedulingPollSlot();
			$new_slot->title = $slot;
			$new_slot->container_guid = $this->guid;
			$new_slot->access_id = $this->access_id;

			
			
			if (!$new_slot->save()) {
				$success = false;
			}
			if ($event === 'update') {
				$users = $this->getVotesByUser();
					
				foreach ($users as $guid => $u) {
					$user = get_entity($guid);
					elgg_set_ignore_access(true);
					$new_slot->vote($user, AnswerValue::UNDEFINED, $new_slot->title);
					elgg_set_ignore_access(false);
				}
				
	//				$new_slot->vote(elgg_get_logged_in_user_entity(), AnswerValue::UNDEFINED, $new_slot->title);
				
			}
		}
		elgg_set_ignore_access($ia);
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
			'type' => 'object',
			'subtype' => 'scheduling_poll_answer',
			'metadata_name_value_pair' => array(
				array('name' => 'slot_guid', 'value' => $guids, 'operand' => 'in'),
			), //*/
			'limit' => 0
		); //*/



		return elgg_get_entities_from_metadata($options);
	}

	/**
	 * Get answers
	 *
	 * @return array $answers
	 */
	public function getVotesByUser() {
		$votes = $this->getVotes();

		$votes_by_user = array();
		foreach ($votes as $vote) {
			$vote = new ElggSchedulingPollAnswer($vote->guid);
			$votes_by_user[$vote->owner_guid][$vote->title] = $vote->getAnswer();
		}
		foreach ($votes_by_user as $user => $vote) {
			// order answer by title
			ksort($votes_by_user[$user]);
		}
		ksort($votes_by_user);
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
					$voteValue = $slot->getVoteValue(get_entity($user_vote->owner_guid));
					if ((int) $voteValue !== AnswerValue::NO || (int) $voteValue !== AnswerValue::NO) {
						$vote++;
					}
				}
			}
			$counts[$slot->guid] = $vote;
		}

		return $counts;
	}

	/**
	 * possible type :
	 * 0 simple poll
	 * 1 advance poll (3 anwser, yes, (yes), no)
	 * @param int $type
	 */
	public function setPollType($type) {
		$this->pollType = $type;
	}

	/**
	 * Return the pollType
	 * @return int
	 */
	public function getPollType() {
		if ($this->pollType) {
			return $this->pollType;
		} else {
			return PollType::SIMPLE;
		}
	}

	function getAddSlotsUrl() {
		return "scheduling/addSlot/" . $this->guid;
	}

}

abstract class PollType {

	const SIMPLE = 0;
	const ADVANCE = 1;

}
