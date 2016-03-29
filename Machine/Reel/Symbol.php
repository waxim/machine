<?php

namespace Machine\Reel;

class Symbol
{
    public $name;

    public $prize;

    public $trail;

    public function getPrize()
    {
        return $this->prize && $this->prize > 0 ? $this->prize : false;
    }
}
