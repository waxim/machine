<?php

namespace Machine;

class Machine
{
    public $name;

    public $cost;

    public $buckets = [
        'buttons' => [],
        'reels'   => [],
        'symbols' => [],
        'trail'   => ""
    ];

    public $bank;

    public function __construct(array $machine)
    {
        $this->buckets['buttons'] = isset($machine['buttons']) ? $machine['buttons'] : false;
        $this->buckets['reels'] = isset($machine['reels']) ? $machine['reels'] : false;
        $this->buckets['symbols'] = isset($machine['symbols']) ? $machine['symbols'] : false;
        $this->buckets['trail'] = isset($machine['trail']) ? $machine['trail'] : false;

        $this->name = $machine['core']['name'];
        $this->cost = $machine['core']['cost'];

        $this->bank = $machine['bank'];

        // seed our reels with symbols
        foreach ($this->buckets['reels'] as $key => $reel) {
            $reel->fillWithSymbols($this->buckets['symbols']);
            $reel->spin();
        }

        return true;
    }

    public function tick()
    {
        if ($this->canSpin()) {
            $this->spin();

            if ($this->trail() && $this->trail()->active()) {
                while ($this->trail()->active()) {
                    $this->trail()->tick();
                }
            }
        }

        return true;

    }

    public function button($index)
    {
        return isset($this->buckets['buttons'][$i]) ? $this->buckets['buttons'][$i] : false;
    }

    public function reel($i)
    {
        return isset($this->buckets['reels'][$i]) ? $this->buckets['reels'][$i] : false;
    }

    public function spin()
    {
        foreach ($this->buckets['reels'] as $reel) {
            $reel->spin();
        }

        return $this->winner() ? $this->addWin() : false;
    }

    public function trail()
    {
        return false;
    }

    public function collect()
    {
        return $this->bank->total();
    }

    public function addWin()
    {
        return $this->bank->add($this->prize());
    }

    public function deductCredit()
    {
        $this->bank->deduct($this->cost);
    }

    public function canSpin()
    {
        return $this->bank->canAfford($this->cost);
    }
}
