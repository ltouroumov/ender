<?php
namespace Ender\Event;
use Ender\Util\ArrayCollection;


class EventQueue {

	function __construct() {
		$this->queue = new ArrayCollection();
	}

}