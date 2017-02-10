<?php

/* ***************************************************************************
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

class ElggSchedulingPollAnswer extends ElggObject {
	
	/**
	 * Intialize attributes
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'scheduling_poll_answer';
	}
	
	public function __construct($guid=null){
		parent::__construct();
        if ($guid) {
            $this->load($guid);
        }
	}
	
	public function getAnswer(){
		return $this->answer;
	}
	
	public function setAnswer($answer){
		$this->answer = $answer;
	}
	
	public function setSlotGuid($sguid){
		$this->slot_guid = $sguid;
	}
	
	public function getSlotGuid(){
		return $this->slot_guid;
	}
	
	
	
	public function SetSlotTimestamp($ts){
		$this->slotTimestamp = $ts;
	}
	
}