<?php
namespace Ender\Loader;
require_once __DIR__.'/../Util/ArrayCollection.php';

use Ender\Util\ArrayCollection;

class ClassLoader {
	
	private $loaders, $registered;

	public function __construct() {
		$this->loaders = new ArrayCollection();
		$this->loaders->setDefault(function ($key) {
			return new ArrayCollection();
		});
	}
	
	public function addHandler($namespace, $loader) {
		$namespace = $this->sanitize($namespace);
		$loader->setBaseNamespace($namespace);

		$this->loaders->get($namespace)->add($loader);
	}
	
	public function loadAll($ary) {
		foreach($ary as $class) {
			$this->load($class);
		}
	}
	
	public function load($class) {
		$class = $this->sanitize($class);
		//echo "Class: ", $class, PHP_EOL;
		if (class_exists($class))
			return true;
		
		foreach ($this->loaders as $ns => $handlers) {
			//echo "Trying '$ns'", PHP_EOL;
			if (fnmatch($ns, $class, FNM_NOESCAPE) === true) {
				$handlers->apply(function($handler) use ($class) {
					$handler->loadClass($class);
				});
			}
		}
		
		if (!(class_exists($class, false) or interface_exists($class, false))) {
			throw new \Exception('Cannot load class ' . $class);
		}
	}

	public function dump() {
		echo __CLASS__.' Dump:', PHP_EOL;
		echo $this->registered ? 'Online' : 'Offline', PHP_EOL;

		foreach ($this->loaders as $ns => $handlers) {
			echo "$ns ->", PHP_EOL;
			foreach ($handlers as $handler) {
				echo "\t", $handler->info();
			}
			echo PHP_EOL;
		}
		echo PHP_EOL;
	}
	
	public function register() {
		$this->registered = true;
		spl_autoload_register(array(__CLASS__, 'load'));
	}
	
	private function sanitize($class) {
		return str_replace(array('.', '/', ':'), '\\', $class);
	}
	
}