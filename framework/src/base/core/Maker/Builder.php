<?php
namespace Ender\Maker;
use Ender\Util\ArrayWrapper;

class Builder {
	
	private $impl;
	private $args;
	private $sets;
	function __construct($impl) {
		$this->impl = $impl;
		$this->args = [];
		$this->sets = [];
	}

	function setArguments($args) {
		$this->args = $args;
	}

	function addSetters($sets) {
		$this->sets = $sets;
	}

	function __invoke($args = []) {
		return $this->build();
	}

	function build() {
		$argv = $this->getValues();
		if (is_callable($this->impl)) {
			$obj = call_user_func_array($this->impl, $argv);
		} else {
			$ref = new \ReflectionClass($this->impl);
			$obj = $ref->newInstanceArgs($argv);
		}
		foreach ($this->sets as $method => $args) {
			call_user_func_array([$obj, $method], $args);
		}

		return $obj;
	}

	protected function getValues() {
		return array_map(function($itm) {
			if($itm instanceof Builder)
				return $itm();
			return $itm;
		}, $this->args);
	}

}