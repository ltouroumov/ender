<?php
namespace Ender\Util;
class ArrayIterator implements \Iterator {
	
	private $data;
	private $keys;
	private $idx;
	public function __construct($data = array()) {
		$this->data = $data;
		$this->keys = array_keys($data);
		$this->rewind();
	}
	
	public function current() {
		return $this->data[$this->key()];
	}
	public function key() {
		return $this->keys[$this->idx];
	}
	public function next() {
		$this->idx++;
	}
	public function rewind() {
		$this->idx = 0;
	}
	public function valid() {
		return isset($this->keys[$this->idx]);
	}
						
}