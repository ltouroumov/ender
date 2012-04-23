<?php
require_once __DIR__.'/../lib/ender-core.phar';
use Ender\Maker;
// use Ender\Core\Config;

class Logger {
	public static $IC = 0;
	function __construct() { $this->_id = self::$IC++; }
}
class Cache {
	public static $IC = 0;
	function __construct() { $this->_id = static::$IC++; }
	function setEnabled($val) { $this->enabled = $val; }
}
class FileCache extends Cache {
	function __construct($path) { parent::__construct(); $this->path = $path; }
}
class MemCache extends Cache {
	function __construct($server) { parent::__construct(); $this->server = $server; }
}
class Kernel {
	function __construct(Logger $log, Cache $cache) {
		$this->logger = $log; $this->cache = $cache;
	}
}

$factory = new Maker\Factory();
$factory->register('app.logger', 'Logger', [], [], '@singleton');
$factory->register('app.cache.file', 'FileCache', [
	'/tmp/cache',
], [
	'setEnabled' => [false]
], '@singleton');
$factory->register('app.cache.mem', 'MemCache', [
	'127.0.0.1:1024',
], [
	'setEnabled' => [true]
], '@singleton');
$factory->alias('app.cache', 'app.cache.mem');
$factory->register('app.kernel', 'Kernel', [
	$factory->ref('app.logger'), $factory->ref('app.cache'),
]);

echo "== Singleton logger ==", PHP_EOL;
var_dump($factory->make('app.logger'));
var_dump($factory->make('app.logger'));
var_dump($factory->make('app.logger'));
var_dump(Logger::$IC);

echo "== Setter mode ==", PHP_EOL;
var_dump($factory->make('app.cache.file'));
var_dump($factory->make('app.cache.mem'));
var_dump(Cache::$IC);

echo "== Aliases ==", PHP_EOL;
var_dump($factory->make('app.cache'));

echo "== References ==", PHP_EOL;
var_dump($factory->make('app.kernel'));