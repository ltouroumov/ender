<?php

trait Accessible {
	
	protected $__properties = [];
	private function buildPropertiesCache() {
		if ($this->__properties) return;
		
		$refClass = new ReflectionClass($this);
		$props = $refClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
		foreach ($props as $prop) {
			if (preg_match('/@Property\(([^\)]+)\)/', $prop->getDocComment(), $matches)) {
				$json = sprintf('{%s}', preg_replace('/(\w+): ([^,]+)/', '"$1": $2', $matches[1]));
				$info = json_decode($json);
				$info->property = $prop->getName();
				$name = isset($info->name) ? $info->name : $info->property;
				$this->__properties[$name] = $info;
			}
		}
	}
	
	function __get($name) {
		$this->buildPropertiesCache();
		if (array_key_exists($name, $this->__properties)) {
			$info = $this->__properties[$name];
			
			if (isset($info->read) && $info->read === true) {
				$prop = new ReflectionProperty($this, $info->property);
				$prop->setAccessible(true);
				return $prop->getValue($this);
			}
			if (isset($info->getter) && $info->getter !== null) {
				return call_user_func([$this, $info->getter]);
			}
		} else {
			throw new Exception('Property ' . $name . ' does not exist');
		}
	}
	function __set($name, $val) {
		$this->buildPropertiesCache();
		if (array_key_exists($name, $this->__properties)) {
			$info = $this->__properties[$name];
			
			if (isset($info->write) && $info->write === true) {
				$prop = new ReflectionProperty($this, $info->property);
				$prop->setAccessible(true);
				$prop->setValue($this, $val);
			} else if (isset($info->setter) && $info->setter) {
				call_user_func([$this,$info->setter], $val);
			} else {
				throw new Exception('Cannot access property, write not enabled');
			}
		} else {
			throw new Exception('Property ' . $name . ' does not exist');
		}
	}
}

class SomeClass {
	use Accessible;
	
	/** @Property(name: "Properties", read: true, write: true) */
	private $prop;
	
	/** @Property(name: "Informations", setter: "setInfo", read: true) */
	protected $info;
	
	protected function setInfo($val) {
		$this->info = "hi ".$val;
	}
}