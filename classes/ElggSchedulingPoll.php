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
}
