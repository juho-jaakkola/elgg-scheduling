<?php

/**
 * Class that represents ElggObject of subtype scheduling_poll_slot
 */
class ElggSchedulingPollSlot extends ElggObject {

	/**
	 * Intialize attributes
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'scheduling_poll_slot';
	}

	/**
	 * Add a new answer to this slot
	 *
	 * @param ElggUser $user The user who is voting
	 * @return bool True on success
	 */
	public function vote(ElggUser $user) {
		return $this->annotate('scheduling_poll_answer', true, $this->access_id, $user->guid);
	}

	/**
	 * Remove existing answer from this user
	 *
	 * @param ElggUser $user The user whose vote is being removed
	 * @return bool True on success
	 */
	public function removeVote(ElggUser $user) {
		return elgg_delete_annotations(array(
			'guid' => $this->guid,
			'annotation_owner_guid' => $user->guid,
			'annotation_name' => 'scheduling_poll_answer',
			'limit' => 0,
		));
	}
}
