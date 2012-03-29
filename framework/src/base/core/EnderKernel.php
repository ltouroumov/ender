<?php
require __DIR__.'/Loader/ClassLoader.php';
use Ender\Loader\ClassLoader;

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
			$this->loader = new ClassLoader();
		}
		
		return $this->loader;
	}

	public static function exec($func) {
		return call_user_func($func, self::getInstance());
	}
}