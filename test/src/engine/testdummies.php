<?php

require_once "engine/BMDie.php";
require_once "engine/BMSkill.php";
require_once "engine/BMContainer.php";
require_once "engine/BMAttack.php";

// well defined skill classes with which to test
class BMSkillTesting extends BMSkill {
    public static $hooked_methods = array("test");

    public static function test($args) {
        $args[0] .= "testing";
    }
}

class BMSkillTesting2 extends BMSkill {
    public static $hooked_methods = array("test");

    public static function test($args) {
        $args[0] .= "still testing";
    }

}

class BMSkillAVTesting extends BMSkill {
    public static $hooked_methods = array("assist_values");

    public static function assist_values($args) {
        $args[3] = array(1);
    }

}

class BMDieTesting extends BMDie {
    public $testvar = "";

    public function test() {
        $this->testvar = "";

        $this->run_hooks(__FUNCTION__, array(&$this->testvar));
    }
}

class BMContTesting extends BMContainer {

}

class BMAttTesting extends BMAttack {
    public function test_ovm_helper($game, $many, $one, $compare) {
        return search_ovm_helper($game, $many, $one, $compare);
    }
}

class DummyGame {
    public $dice = array();

    public function add_die($player, $die) {
        $this->dice[] = array($player, $die);
    }

    public $swingrequest;

    public function request_swing_values($die, $swingtype) {
        $this->swingrequest = array($die, $swingtype);
    }

    public function require_values() {
        throw new Exception("require_values called");
    }

}

?>