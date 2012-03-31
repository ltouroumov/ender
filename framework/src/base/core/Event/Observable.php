<?php
namespace Ender\Event;
use Ender\Util\ArrayWrapper;

trait Observable {
	
	protected $_observers = [];
	private function __initObservable() {
		if (! $this->_observers) {
			$this->_observers = new ArrayWrapper();
		}
	}
	public function addObserver(IObserver $observer) {
		$this->__initObservable();

		$this->_observers->add($observer);
	}

	protected function notifyObservers($args) {
		$this->_observers->apply(function($obs) use ($args) {
			$obs->onChange($this, $args);
		});
	}

}