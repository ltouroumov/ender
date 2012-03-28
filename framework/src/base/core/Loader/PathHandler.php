<?php
namespace Ender\Core\Loader;

//require_once 'Ender/Core/Loader/BaseHandler.php';
class PathHandler extends BaseHandler {
	
	private $base;
	function __construct($path, $base = null) {
		$this->path = $path;
		$this->base = $base;
	}

	function loadClass($class) {
		$file = $this->classFile(str_replace($this->base, '', $class));
		//echo "Try load: ", $file, PHP_EOL;
		if (file_exists($this->path.'/'.$file)) {
			require_once $this->path.'/'.$file;
		}
	}

	function info() {
		return sprintf('[%s] %s', 'Path', $this->path);
	}
	
}