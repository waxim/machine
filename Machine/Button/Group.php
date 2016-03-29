<?php

namespace Machine\Button;

class Group
{
    public $buttons = [];

    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    public function validPress($key)
    {
        if (array_key_exists($key, $this->buttons)) {
            return $this->buttons[$key]->press();
        }

        return false;
    }
}
