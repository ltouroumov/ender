<?php
namespace Ender\Util\Collection;

trait Sortable {
	
	public function sort($arg) {
		return is_callable($arg) ? $this->sortWithCallback($arg) : $this->sortWithProperty($arg);
	}

	protected function sortWithCallback($func) {
		$data = $this->data;
		usort($data, $func);

		return new static($data);
	}

	protected function sortWithProperty($prop) {
		$data = $this->data;
		$props = array_map(function($prop) { return trim($prop); }, explode(',', $prop));
		usort($data, function($a, $b) use ($props) {
			foreach ($props as $prop) {
				$aval = self::sortGetProperty($a, $prop);
				$bval = self::sortGetProperty($b, $prop);
				if ($aval == $bval)
					continue;
				
				return self::sortCompare($aval, $bval);
			}
			return 0;
		});

		return new static($data);
	}

	protected static function sortGetProperty($obj, $prop) {
		if (is_object($obj)) {
			return $obj->$prop;
		} else {
			return $obj[$prop];
		}
	}
	protected static function sortCompare($a, $b) {
		if ($a == $b) return 0;

		if (is_numeric($a) && is_numeric($b)){
			echo 'N';
			return $a > $b ? 1 : -1;
		}
		if (is_string($a) && is_string($b)){
			echo 'S';
			return strnatcasecmp($a, $b);
		}
		//Fallback
		echo 'F';
		return $a > $b ? 1 : -1;
	}

}