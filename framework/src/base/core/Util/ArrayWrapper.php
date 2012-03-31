<?php
namespace Ender\Util;

// In case autoloader has not kicked in yet
require_once __DIR__.'/ArrayIterator.php';
use Ender\Util\ArrayIterator;

/**
 * @author Jeremy David <ltouroumov@gmail.com>
 * 
 * Array wrapper
 */
class ArrayWrapper implements \ArrayAccess, \IteratorAggregate, \Countable {
	
	private $current = 0;
	private $data;
	private $default;
	
	public function __construct($data = array()) {
		$this->data = $data instanceof ArrayWrapper ? $data->toArray() : $data;
		$this->updateCurrent();
		$this->default = null;
	}
	
	/**
	 * If the default property is set the provided proc will be called
	 * each time an unset index is accessed to provide a value.
	 * 
	 * @param callback $proc Default proc
	 */
	public function setDefault($proc) {
		$this->default = $proc;
	}

	/**
	 * Returns a uniquified version of the collection
	 *
	 * @return ArrayWrapper
	 */
	public function unique() {
		return new ArrayWrapper(array_unique($this->data));
	}

	/**
	 * Returns a new collection with the result of the callback for each item
	 *
	 * @param callback $func Mapper function
	 */
	public function map($func) {
		$col = new self();
		foreach ($this->data as $key => $value) {
			$col[$key] = call_user_func($func, $value, $key);
		}
		return $col;
	}

	/**
	 * Function to create keys from values
	 *
	 * @param callback $func Mapper function
	 */
	public function mapKeys($func) {
		$new = new self();
		foreach ($this->data as $value) {
			$key = call_user_func($func, $value);
			$new[$key] = $value;
		}
		return $new;
	}

	/**
	 * Walks the collection calling the function with each item
	 *
	 * @param callback $func Walking function
	 */
	public function apply($func) {
		foreach ($this->data as $key => $value) {
			call_user_func($func, $value, $key);
		}
	}

	/**
	 * Appends array or collection to self
	 * 
	 * @param array|ArrayWrapper $data The collection to append
	 */
	public function append($data) {
		if ($data instanceof self)
			$data = $data->toArray();

		$this->data = array_merge($this->data, $data);
	}

	/**
	 * Filters the collection using the proc
	 * 
	 * @param callback $func Filter function
	 */
	public function find($func) {
		$new = new self();
		foreach ($this->data as $key => $val) {
			if (call_user_func($func, $val, $key))
				$new->set($key, $val);
		}
		return $new;
	}

	/**
	 * Returns the keys of the collection
	 */
	public function keys() {
		return array_keys($this->data);
	}

	/**
	 * Returns the underlying array
	 */
	public function toArray() {
		return $this->data;
	}

	/**
	 * Adds the value at the end of the collection
	 * 
	 * @param any $value Value to append
	 */
	public function add($value) {
		$this->data[$this->nextKey()] = $value;
	}
	/**
	 * Sets the value at a specific key
	 * 
	 * @param string|scalar $key
	 * @param any $value
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	/**
	 * Get an object at a specific key
	 *
	 * @param string|scalar $key
	 */
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
	/**
	 * Get all the values from an array of keys
	 * 
	 * @param array $keys
	 */
	public function getAll($keys) {
		$new = new self();
		foreach ($keys as $key) {
			$new->set($key, $this->get($key));
		}
		return $new;
	}

	/**
	 * Test for presence of a specific key
	 * 
	 * @param string|scalar $key
	 */
	public function has($key) {
		return isset($this->data[$key]);
	}

	/**
	 * Removes item from the collection
	 * 
	 * @param string|scalar $key
	 */
	public function del($key) {
		unset($this->data[$key]);
	}
	
	/* From Countable */
	public function count() {
		return count($this->data);
	}

	/* From IteratorAggregate */
	public function getIterator() {
		return new ArrayIterator($this->data);
	}
	
	/* From ArrayAccess */
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