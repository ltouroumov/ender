<?php
namespace Ender\Event;
use Ender\Util\MetaCollection;


class EventQueue {

	function __construct() {
		$this->queue = new MetaCollection();
	}

	function subscribe($evt, $handler) {
		$this->queue->add($handler, [ 'event' => $evt ]);
	}

	function publish($evt, $args = []) {
		$handlers = $this->queue->metaFind(function($meta) use ($evt) {
			return $meta['event'] == $evt;
		});
		
		foreach ($handlers as $handler) {
			$handler($args);
		}
	}

}