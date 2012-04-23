<?php
namespace Ender\Util\Collection;

interface IHash extends ICollection {
	public function set($key, $val);
	public function get($key);

	public function has($key);

	public function merge($data);
}