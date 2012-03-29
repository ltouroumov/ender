<?php
$phar = basename(__FILE__);
Phar::mapPhar($phar);

#defined('LOAD_ENDER') || define('LOAD_ENDER', true);

#if (LOAD_ENDER) {
	require_once 'phar://'.$phar.'/EnderKernel.php';
	require_once 'phar://'.$phar.'/Loader/BaseHandler.php';
	require_once 'phar://'.$phar.'/Loader/PathHandler.php';
	require_once 'phar://'.$phar.'/Loader/PharHandler.php';

	use Ender\Loader\PharHandler;
	use Ender\Loader\PathHandler;

	EnderKernel::exec(function($core) use ($phar) {
		$loader = $core->loader();
		$loader->register();
		$loader->addHandler('Ender.*', new PharHandler($phar, '/'));
	});

	# array_shift($argv);
	# if (count($argv) > 0) {
	# 	$bin_util = 'phar://'.$phar.'/bin/'.$argv[0].'.php';
	# 	if (file_exists($bin_util)) {
	# 		array_shift($argv);
	# 		include $bin_util;
	# 	}
	# }
#}

__HALT_COMPILER();