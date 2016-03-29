<?php

namespace Machine;

class Button
{
    public $name;

    public $value;

    public $callback;

    public function __construct($name, $callback)
    {
        $this->name = $name;

        if (is_callable($callback)) {
            $this->callback = $callback;
        } else {
            $this->callback = function () {
                return $callback;
            }
        }
    }

    public function press($machine)
    {
        $machine->lastPressed = $this;
        return $this->callback($machine);
    }
}
