<?php
namespace Ender\Util\Collection;

interface IList extends ICollection {
	public function push($obj);
	public function pop();

	public function unshift($obj);
	public function shift();

	public function get($idx);

	public function count();

	public function slice($offset, $length = null);
	public function reverse();

	public function append($data);
	public function prepend($data);
}