<?php
namespace Ender\Util\Collection;

interface ISet extends ICollection {
	public function add($obj);
	public function del($obj);

	public function contains($obj);
}