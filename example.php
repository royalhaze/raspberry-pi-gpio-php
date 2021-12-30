<?php

require __DIR__.'/src/GPIO.php';

$gpio = new GPIO(12);

$gpio->set_direction(GPIO::DIRECTION_IN);

echo $gpio->get_direction();

$gpio->set_value(1);

echo $gpio->get_value();