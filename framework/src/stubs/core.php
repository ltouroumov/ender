<?php
$phar = basename(__FILE__);
Phar::mapPhar($phar);

defined('LOAD_ENDER') || define('LOAD_ENDER', true);
defined('ENDER_LOADED') && return;

if (LOAD_ENDER) {
	require_once 'phar://'.$phar.'/lib/EnderKernel.php';
	require_once 'phar://'.$phar.'/lib/core/Loader/BaseHandler.php';
	require_once 'phar://'.$phar.'/lib/core/Loader/PathHandler.php';
	require_once 'phar://'.$phar.'/lib/core/Loader/PharHandler.php';

	use Ender\Core\Loader\PharHandler;
	use Ender\Core\Loader\PathHandler;

	Ender::core(function($core) use ($phar) {
		$loader = $core->loader();
		$loader->register();
		$loader->addHandler('Ender.Core.*', new PharHandler($phar, '/lib/core'));
		$loader->addHandler('Ender.Util.*', new PharHandler($phar, '/lib/util'));
	});

	array_shift($argv);
	if (count($argv) > 0) {
		$bin_util = 'phar://'.$phar.'/bin/'.$argv[0].'.php';
		if (file_exists($bin_util)) {
			array_shift($argv);
			include $bin_util;
		}
	}
}

__HALT_COMPILER();