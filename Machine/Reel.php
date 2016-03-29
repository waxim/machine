<?php

namespace Machine;

class Reel
{
    public $slots;

    public $position = 0;

    public $reel = [];

    public $canHold = 1;

    public $canNudge = 1;

    public $held = 0;

    public function __construct($slots, $canHold = 1, $canNudge = 1)
    {
        $this->slots = $slots;
        $this->canHold = $canHold;
        $this->canNudge = $canNudge;

        return true;
    }

    public function up($number = 1)
    {
        if (!$this->held && $this->canNudge) {
            return $this->position = $this->position - $number;
        }

        return false;
    }

    public function down($number = 1)
    {
        if (!$this->held && $this->canNudge) {
            return $this->position = $this->position - $number;
        }

        return false;
    }

    public function spin()
    {
        if (!$this->held) {
            $this->position = mt_rand(0, count($this->reel) - 1);
            shuffle($this->reel);
        }

        return $this->identify();
    }

    public function identify()
    {
        return $this->reel[$this->position];
    }

    public function fillWithSymbols(array $symbols)
    {
        $this->reel = array_combine(range(1, $this->slots), range(1, $this->slots));
        foreach ($this->reel as $symbol) {
            $number = mt_rand(0, count($symbols) - 1);
            $this->reel[$key] = $symbol;
        }

        return $this;
    }

    public function toggleHold()
    {
        if ($this->canHold) {
            $this->held = $this->held ? 0 : 1;
        }

        return true;
    }
}
