<?php
namespace Ender\Maker;
use Ender\Util\ArrayWrapper;
use Ender\Util\MetaCollection;

class Factory {
	
	private $factories;
	private $aliases;
	private $instances;

	function __construct() {
		$this->factories = new MetaCollection();
		$this->aliases = new ArrayWrapper();
		$this->instances = new ArrayWrapper();
	}

	function register($name, $impl, $args = [], $sets = [], $archetype = false) {
		$cls = $this->getBuilder($impl, $args, $sets);
		$this->factories->set($name, $cls, ['archetype' => $archetype]);
	}

	function ref($name) {
		return new Builder(function() use ($name) {
			return $this->make($name);
		});
	}

	function alias($name, $other) {
		$this->aliases[$name] = $other;
	}

	function make($name) {
		if ($this->aliases->has($name)) {
			$name = $this->aliases->get($name);
		}
		if ($this->factories->has($name)) {
			$factory = $this->factories->get($name);
			$meta = $this->factories->metaGet($name);
			if ($meta['archetype'] == '@singleton') {
				if ($this->instances->has($name)) {
					return $this->instances->get($name);
				} else {
					$obj = $factory();
					$this->instances->set($name, $obj);
					return $obj;
				}
			} else {
				return $factory();
			}
		}
	}

	protected function getBuilder($impl, $args, $sets) {
		$builder = new Builder($impl);
		$builder->setArguments($args);
		$builder->addSetters($sets);

		return $builder;
	}


}