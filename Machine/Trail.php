<?php

namespace Machine;

class Trail
{
    public $length;

    public $runs;

    public $award;

    public $callback;

    public $tick = 0;

    public function __construct($length, $award, $runs, $callback)
    {
        $this->length = $length;
        $this->award = $award;
        $this->runs = $runs;
        $this->callback = $callback;

        return true;
    }

    public function tick()
    {
        if ($this->tick < $this->runs) {
            return $this->callback();
        }
        $this->tick++;
        return false;
    }

    public function giveAward()
    {
        return $this->award;
    }
}
