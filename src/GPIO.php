<?php

class GPIO
{
    public $pin;

    const DIRECTION_IN = 'in';
    const DIRECTION_OUT = 'out';

    public function __construct(int $pin)
    {
        $this->pin = $pin;

        $this->check_pin_status();

        return $this;
    }

    public function set_direction($direction): GPIO
    {
        exec('echo "' . $direction . '" > /sys/class/gpio/gpio' . $this->pin . '/direction');

        return $this;
    }

    public function get_direction()
    {
        return exec('cat /sys/class/gpio/gpio' . $this->pin . '/direction');
    }

    public function get_value(): float
    {
        return exec('cat /sys/class/gpio/gpio' . $this->pin . '/value');
    }

    public function set_value($value): GPIO
    {
        if ($this->get_value($this->pin) != $value) {
            exec('echo "' . $value . '" > /sys/class/gpio/gpio' . $this->pin . '/value');
        }
        return $this;
    }

    private function make_pin_ready()
    {
        exec('echo "' . $this->pin . '" > /sys/class/gpio/export');
    }

    private function is_pin_ready(): bool
    {
        return in_array('gpio' . $this->pin, scandir('/sys/class/gpio/'));
    }

    private function check_pin_status()
    {
        if (!$this->is_pin_ready()) {
            $this->make_pin_ready();
        }
    }
}