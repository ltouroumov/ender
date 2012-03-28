<?php
namespace Ender\Util;

class MetaCollection extends ArrayCollection {
	
	private $meta;

	public function __construct($data = [], $meta = []) {
		parent::__construct($data);
		$this->meta = $meta instanceof ArrayCollection ? $meta : new ArrayCollection($meta);
	}

	public function set($name, $value, $meta = []) {
		parent::set($name, $value);
		$this->meta->set($name, $meta);
	}

	public function add($value, $meta = []) {
		parent::add($value);
		$this->meta->set($this->getKey(), $meta);
	}

	public function metaGet($name) {
		return $this->meta->get($name);
	}
	public function metaSet($name, $meta) {
		$this->meta->set($name, $meta);
	}

}