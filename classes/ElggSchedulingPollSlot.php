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
	 * -1 => undefined (only if the poll has changed)
	 * 0  => not voted yet(false)
	 * 1  => yes
	 * 2  => (yes) maybe
	 * 3  => no, not available
	 * 
	 * @param ElggUser $user The user who is voting
	 * @return bool True on success
	 */
	public function vote($user, $answer = 0, $valueTosave = 0) {

		if ($this->hasVoted($user) && $answer != AnswerValue::UNDEFINED) {
			// update OBJECT
			$vote = $this->getVote($user);
			$userAnswer = new ElggSchedulingPollAnswer($vote->guid);
			$userAnswer->setAnswer($answer);

			$userAnswer->save();
		} else {
			$userAnswer = new ElggSchedulingPollAnswer();

			$userAnswer->setAnswer($answer);
			$userAnswer->title = $valueTosave;
			$userAnswer->setSlotGuid($this->guid);

			$res = $userAnswer->save();
		}
		return $res;
	}

	/**
	 * Check if user has voted this slot
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	private function hasVoted(ElggUser $user) {
		$vote = $this->getVote($user);

		return !empty($vote);
	}

	/**
	 * Return the vote value for this slot
	 *
	 * @param ElggUser $user
	 * @return string
	 */
	public function getVote(ElggUser $user) {
		$vote = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'scheduling_poll_answer',
			'owner' => $user->guid,
			'metadata_name_value_pair' => array(
				array('name' => 'slot_guid', 'value' => $this->guid, 'operand' => '='),
			),
		));

		if ($vote) {
			// only the first result
			$res = $vote[0];
		} else {
			$res = array();
		}

		return $res;
	}

	public function getVoteValue(ElggUser $user) {
		$vote = $this->getVote($user);
		return $vote[0]->value;
	}

	/**
	 * Remove existing answer from this user
	 *
	 * @param ElggUser $user The user whose vote is being removed
	 * @return bool True on success
	 */
	public function removeVote(ElggUser $user) {

		// @TODO remove this function
		return elgg_delete_annotations(array(
			'guid' => $this->guid,
			'annotation_owner_guid' => $user->guid,
			'annotation_name' => 'scheduling_poll_answer',
			'limit' => 0,
		));
	}

	public function getTitle() {
		return $this->title;
	}
}

abstract class AnswerValue {

	const YES = 3;
	const MAYBE = 2;
	const NO = 1;
	const VOID = 0;
	const UNDEFINED = 4;

}
