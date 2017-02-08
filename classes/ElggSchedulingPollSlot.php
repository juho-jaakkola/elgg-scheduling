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
    public function vote(ElggUser $user, $answer = 0) {
        if ($this->hasVoted($user)) {
            // update annotation 
            $vote = $this->getVote($user);

            $annotate = elgg_get_annotation_from_id($vote[0]->id);
            $annotate->value = $answer;
            $annotate->save();

            $res = $annotate->guid;
        } else {
            $res = $this->annotate('scheduling_poll_answer', $answer, $this->access_id, $user->guid);
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
        $vote = elgg_get_annotations(array(
            'guid' => $this->guid,
            'annotation_owner_guid' => $user->guid,
            'annotation_name' => 'scheduling_poll_answer',
        ));

        return !empty($vote);
    }

    /**
     * Return the vote value for this slot
     *
     * @param ElggUser $user
     * @return string
     */
    public function getVote(ElggUser $user) {
        $vote = elgg_get_annotations(array(
            'guid' => $this->guid,
            'annotation_owner_guid' => $user->guid,
            'annotation_name' => 'scheduling_poll_answer',
        ));

        return $vote;
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
        return elgg_delete_annotations(array(
            'guid' => $this->guid,
            'annotation_owner_guid' => $user->guid,
            'annotation_name' => 'scheduling_poll_answer',
            'limit' => 0,
        ));
    }
    
    public function getTitle(){
        return $this->title;
    }

}

abstract class AnswerValue {

    const YES = 3;
    const MAYBE = 2;
    const NO = 1;
    const VOID = 0;

}
