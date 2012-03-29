<?php
require_once __DIR__.'/../lib/ender-core.phar';
use Ender\Event\EventQueue;

$queue = new EventQueue();
$queue->subscribe('toto', function() { echo "Toto 1\n"; });
$queue->subscribe('toto', function() { echo "Toto 2\n"; });
$queue->subscribe('toto', function() { echo "Toto 3\n"; });

$queue->subscribe('tata', function() { echo "Tata 1\n"; });
$queue->subscribe('tata', function() { echo "Tata 2\n"; });
$queue->subscribe('titi', function() { echo "Titi 3\n"; });

$queue->publish('toto');
$queue->publish('tata');
$queue->publish('titi');