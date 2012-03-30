<?php
require_once __DIR__.'/../lib/ender-core.phar';

class Customer {
	use Ender\Event\Observable;

	function setAddress($addr) {
		$this->addr = $addr;
		$this->notifyObservers(['address', $addr]);
	}
	function setName($name) {
		$this->name = $name;
		$this->notifyObservers(['name', $name]);
	}
}
class CustomerObserver implements Ender\Event\IObserver {
	function onChange($cust, $args) {
		echo "Customer changed {$args[0]} to {$args[1]}\n";
	}
}

$customer = new Customer();
$customer->addObserver(new CustomerObserver());
$customer->setName('toto');
$customer->setAddress('world');