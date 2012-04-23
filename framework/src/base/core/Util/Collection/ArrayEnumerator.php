<?php
namespace Ender\Util\Collection;

class ArrayEnumerator implements \Iterator {
	
	private $data;
	public function __construct($data) {
		$this->data = $data instanceof IDataCollection ? $data->getData() : $data;
	}

	public function current() {
		return current($this->data);
	}

	public function next() {
		next($this->data);
	}

	public function key() {
		return key($this->data);
	}

	public function valid() {
		$key = $this->key();
		return ($key !== null && $key !== false);
	}

	public function rewind() {
		reset($this->data);
	}

}