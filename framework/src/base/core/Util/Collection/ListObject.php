<?php
namespace Ender\Util\Collection;

class ListObject implements IList {
	use Enumerable, Queryable;

	private $data;
	function __construct($data = []) {
		$this->data = $data instanceof static ? $data->getData() : $data;
	}

	public function getEnumerator() {
		return new ArrayEnumerator($this->data);
	}

	public function push($obj) {
		$this->data[] = $obj;
	}
	public function pop() {
		return array_pop($this->data);
	}

	public function shift() {
		return array_shift($this->data);
	}
	public function unshift($val) {
		array_unshift($this->data, $val)
	}

	public function count() {
		return count($this->data);
	}
	
	public function slice($offset, $length = null) {
		return new static(array_slice($this->data, $offset, $length));
	}
	public function reverse() {
		return new static(array_reverse($this->data));
	}

	public function append($data) {
		return new static(array_merge($this->data, array_values($data instanceof static ? $data->getData() : $data)));
	}
	public function prepend($data) {
		return new static(array_merge(array_values($data instanceof static ? $data->getData() : $data), $this->data));
	}

	public function getData() {
		return $this->data;
	}
}