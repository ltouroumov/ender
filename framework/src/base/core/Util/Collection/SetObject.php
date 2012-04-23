<?php
namespace Ender\Util\Collection;

class SetObject implements ISet, IDataCollection {
	use Enumerable;

	private $data;

	public function __construct($data = [], $coll = false) {
		$this->data = static::hashArray($data instanceof static ? $data->getData() : $data);
		$this->_enum_collection_type = ($coll === false ? '\Ender\Util\Collection\ListObject' : $coll);
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

	public function size() {
		return count($this->data);
	}

	protected static function hash($obj) {
		if (is_object($obj)) {
			return 'o'.spl_object_hash($obj);
		} else {
			//TODO: Find better way !
			return 's'.md5(serialize($obj));
		}
	}

	protected static function hashArray($ary) {
		$data = [];
		foreach ($ary as $val) {
			$data[self::hash($val)] = $val;
		}
		return $data;
	}

	public function getData() {
		return $this->data;
	}

}