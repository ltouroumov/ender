<?php
namespace Ender\Util\Collection;

class HashObject implements IHash {
	use Enumerable, Queryable;

	private $this->data;

	public function __construct($data = []) {
		$this->data = $data instanceof static ? $data->getData() : $data;
	}

	public function getEnumerator() {
		return new ArrayEnumerator($this->data);
	}
	public function set($key, $val) {
		$this->data[$key] = $val;
	}
	public function get($key, $def = null) {
		if ($this->has($key)) {
			return $this->data[$key];
		}
		return $def;
	}
	public function has($key) {
		return array_key_exists($key, $this->data);
	}
	public function merge($data) {
		return new static(array_merge($this->data, $data instanceof static ? $data->getData() : $data));
	}

	public function getData() {
		return $this->data;
	}
}