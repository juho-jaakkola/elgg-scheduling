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
     * Reponse possible :
     * 0 => pas voté(false)
     * 1 => Oui
     * 2 => (Oui) peut etre
     * 3 => Non, pas disponible
     * 
	 * @param ElggUser $user The user who is voting
	 * @return bool True on success
	 */
	public function vote(ElggUser $user, $value=0) {
		if ($this->hasVoted($user)) {
			// Allow user to vote only once
			return false;
		}

        
		//return $this->annotate('scheduling_poll_answer', true, $this->access_id, $user->guid);
		return $this->annotate('scheduling_poll_answer', $value, $this->access_id, $user->guid);
	}

	/**
	 * Check if user has voted this slot
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	private function hasVoted(ElggUser $user) {
		$vote = elgg_get_annotations(array(
			'guid' => $this->guid,
			'annotation_owner_guid' => $user->guid,
			'annotation_name' => 'scheduling_poll_answer',
		));

		return !empty($vote);
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
