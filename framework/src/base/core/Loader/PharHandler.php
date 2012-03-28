<?php
namespace Ender\Core\Loader;

//require_once 'Ender/Core/Loader/BaseHandler.php';
class PharHandler extends BaseHandler {
	
	function __construct($phar, $subdir = '/lib') {
		$this->phar = $phar;
		$this->subdir = $subdir;
	}

	function loadClass($class) {
		$file = $this->classFile($class);
		$path = sprintf('phar://%s%s/%s', $this->phar, $this->subdir, $file);
		//echo "Try load: $path", PHP_EOL;
		if (file_exists($path)) {
			include_once $path;
		} else {
			//echo "File does not exist $path", PHP_EOL;
		}
	}

	function info() {
		return sprintf('[%s] %s:%s', 'Phar', $this->phar, $this->subdir);
	}

	
}