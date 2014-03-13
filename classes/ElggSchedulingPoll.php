<?php

/**
 *
 */
class ElggSchedulingPoll extends ElggObject {

	/**
	 *
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'scheduling_poll';
	}

	public function getDays() {
		return ($this->date_end - $this->date_begin) / 60 / 60 / 24;
	}

	/**
	 *
	 */
	public function getTimeFromDaynumber($number) {
		$seconds_of_day = 60 * 60 * 24;

		return $this->date_begin + $number * $seconds_of_day;
	}

	/**
	 * Get answers in a three-dimensional array
	 *
	 * array(
 	 * 		user_guid1 => array(
 	 * 			array(
	 * 				timestamp => array(
	 * 					0 => true,
	 * 					1 => true,
	 * 					2 => false,
	 * 				)
	 * 			)
	 * 		),
 	 *		user_guid2 => array(
 	 * 			array(
	 * 				timestamp => array(
	 * 					0 => false,
	 * 					1 => true,
	 * 					2 => false,
	 * 				)
	 * 			)
	 * 		)
	 * )
	 *
	 * @return array $answers
	 */
	public function getAnswers() {
		$annotations = $this->getAnnotations('scheduling_poll_answer');

		$answers = array();
		foreach ($annotations as $annotation) {
			$answer = unserialize($annotation->value);

			$answers[$annotation->owner_guid] = $answer;
		}

		return $answers;
	}
}
