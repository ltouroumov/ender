<?php
namespace Ender\Util\Collection;

use Ender\Util\Collection\Query;

trait Queryable {
	
	public function query($query_obj = null) {
		if ($query_obj) {
			$query_obj->setCollection($this);

			return $query_obj;
		} else {
			return new Query($this);
		}
	}

}