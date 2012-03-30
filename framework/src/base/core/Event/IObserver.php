<?php
namespace Ender\Event;

interface IObserver {
	public function onChange($self, $args);
}