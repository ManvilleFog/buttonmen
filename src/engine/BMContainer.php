<?php

require_once 'BMDie.php';

/*
 * BMContainer: Managing die groups.
 *
 * @author: Julian Lighton
 */

class BMContainer {
    public $contents = array();

    // keyed by the Names of the skills that the class has, with values of
    // the skill class's name
    //
    // Not that the value is needed, but we use the keys to track
    // which skills we have to avoid duplication.
    protected $skillList = array();


    // Make the container's special choices, then activate the
    // appropriate contents, adding the container's skills to them
    // first
    public function activate($game, $owner) {

    }

    // add a die or container to the end of the container
    public function add_thing($thing) {
        // Only dice and containers
        if (is_a($thing, "BMContainer")  || is_a($thing, "BMDie")) {
            $this->contents[] = $thing;
            return $thing;
        }
        return NULL;
    }

    // skill management
    public function add_skill($skill) {
        $skillClass = "BMSkill$skill";

        // Don't add skills that are already added
        if (!array_key_exists($skill, $this->skillList)) {
            $this->skillList[$skill] = $skillClass;
        }

    }

    public function has_skill($skill) {
        return array_key_exists($skill, $this->skillList);
    }

    public function remove_skill($skill) {
        if (!$this->has_skill($skill)) {
            return FALSE;
        }

        unset($this->skillList[$skill]);

        return TRUE;

    }

    // create the container from an array of dice and containers
    public static function create_from_list($contents, $skills = NULL) {

    }

    // utility methods

    // If we clone the container, we must clone all contents as well
    public function __clone() {
        
    }
}


class BMSelectContainer extends BMContainer {

}

class BMPlasmaContainer extends BMContainer {

}

class BMReserveContainer extends BMContainer {

}

// These last two may not be needed; the engine could possibly use
// generic containers and simply open them first or last.

// Special container for Auxiliary dice and the like. Activated only
// at the start of games.
class BMInitialContainer extends BMContainer {

}

// Special container that is opened last each round, so the dice
// within can replace other dice.
class BMSideboardContainer extends BMContainer {

}

?>