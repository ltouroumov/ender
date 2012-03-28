<?php
require __DIR__.'/core/Loader.php';
use Ender\Core\Loader;

class EnderKernel {

	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	private function __construct() {}

	private $loader = null;
	public function load(/* ... */) {
		$this->loader()->loadAll(func_get_args());
	}
	
	public function loader() {
		if ($this->loader == null) {
			$this->loader = new Loader();
		}
		
		return $this->loader;
	}
}