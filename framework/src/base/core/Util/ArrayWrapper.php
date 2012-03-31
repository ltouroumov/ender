<?php
namespace Ender\Util;

require_once __DIR__.'/ArrayIterator.php';
use Ender\Util\ArrayIterator;

class ArrayCollection implements \ArrayAccess, \IteratorAggregate, \Countable {
	
	private $current = 0;
	private $data;
	private $default;
	
	public function __construct($data = array()) {
		$this->data = $data instanceof ArrayCollection ? $data->toArray() : $data;
		$this->updateCurrent();
		$this->default = null;
	}
	
	public function setDefault($proc) {
		$this->default = $proc;
	}

	public function unique() {
		return new ArrayCollection(array_unique($this->data));
	}


	public function map($func) {
		$col = new self();
		foreach ($this->data as $key => $value) {
			$col[$key] = call_user_func($func, $value, $key);
		}
		return $col;
	}
	public function mapKeys($func) {
		$new = new self();
		foreach ($this->data as $value) {
			$key = call_user_func($func, $value);
			$new[$key] = $value;
		}
		return $new;
	}
	public function apply($func) {
		foreach ($this->data as $key => $value) {
			call_user_func($func, $value, $key);
		}
	}
	public function append($data) {
		if ($data instanceof self)
			$data = $data->toArray();

		$this->data = array_merge($this->data, $data);
	}
	public function find($func) {
		$new = new self();
		foreach ($this->data as $key => $val) {
			if (call_user_func($func, $val, $key))
				$new->set($key, $val);
		}
		return $new;
	}

	public function keys() {
		return array_keys($this->data);
	}
	public function toArray() {
		return $this->data;
	}

	public function add($value) {
		$this->data[$this->nextKey()] = $value;
	}
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	public function get($key) {
		if ($this->offsetExists($key)) {
			return $this->data[$key];
		}
		if ($this->default) {
			$val = call_user_func($this->default, $key);
			$this->set($key, $val);
			return $val;
		}
	}
	public function getAll($keys) {
		$new = new self();
		foreach ($keys as $key) {
			$new->set($key, $this->get($key));
		}
		return $new;
	}
	public function has($key) {
		return isset($this->data[$key]);
	}
	public function del($key) {
		unset($this->data[$key]);
	}
	
	/* Countable */
	public function count() {
		return count($this->data);
	}

	/* IteratorAggregate */
	public function getIterator() {
		return new ArrayIterator($this->data);
	}
	
	/* ArrayAccess */
	public function offsetSet($offset, $value) {
		if ($offset === null) {
			$this->add($value);
		} else {
			$this->set($offset, $value);
		}
	}
	public function offsetGet($offset) {
		return $this->get($offset);
	}
	public function offsetExists($offset) {
		return $this->has($offset);
	}
	public function offsetUnset($offset) {
		$this->del($offset);
	}

	protected function updateCurrent() {
		$this->current = $this->count() - 1;
	}
	protected function getKey() {
		return $this->current;
	}
	protected function nextKey() {
		return ++$this->current;
	}
}