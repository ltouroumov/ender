<?php
namespace Ender\Util\Collection;

class SetObject {
	use Enumerable, Queryable;

	private $data;

	public function __construct($data = []) {
		$this->data = $data instanceof static ? $data->getData() : $data;
	}

	public function getEnumerator() {
		return new ArrayEnumerator($this->data);
	}

	public function add($obj) {
		$this->data[$this->hash($obj)] = $obj;
	}
	public function del($obj) {
		unset($this->data[$this->hash($obj)]);
	}

	public function contains($obj) {
		return array_key_exists($this->hash($obj), $this->data);
	}

	protected function hash($obj) {
		if (is_object($obj)) {
			return 'o'.spl_object_hash($obj);
		} else {
			//TODO: Find better way !
			return 's'.md5(serialize($obj));
		}
	}

}