<?php
namespace Ender\Util\Collection;

trait Enumerable {

	protected $_enum_collection_type = false;
	public function each($func) {
		foreach($this->getEnumerator() as $key => $val) {
			$func($val, $key);
		}
		return $this;
	}

	public function collect($func) {
		$data = [];
		
		foreach ($this->getEnumerator() as $key => $val) {
			$data[$key] = $func($val, $key);
		}
		$class = $this->_enum_collection_type === false ? get_class($this) : $this->_enum_collection_type;
		return new $class($data);
	}

	public function reduce($func, $data = null) {
		foreach($this->getEnumerator() as $key => $val) {
			$data = $func($data, $val, $key);
		}

		return $data;
	}
}