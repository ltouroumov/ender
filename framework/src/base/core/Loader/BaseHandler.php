<?php

namespace Ender\Loader;
abstract class BaseHandler {
	
	protected $baseNamespace;
	public abstract function info();
	public abstract function loadClass($class);
	
	public function setBaseNamespace($base) {
		$this->baseNamespace = str_replace('*', '', $base);
	}

	protected function stripBaseNamespace($className) {
		if ($this->baseNamespace) {
			return substr($className, strlen($this->baseNamespace));
		}

		return $className;
	}

	protected function classFile($className) {
		$className = $this->stripBaseNamespace($className);
		$parts = explode('\\', $className);
		$class = array_pop($parts);
		
		return implode('/', $parts) . '/'. str_replace('_', '/', $class).'.php';
	}
}