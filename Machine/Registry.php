<?php

namespace Machine;

class Registry
{
    public $data = [];

    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : false;
    }

    public function set($key, $value)
    {
        return $this->data[$key] = $value;
    }
}
