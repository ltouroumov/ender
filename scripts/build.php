<?php

$fw_base=realpath(__DIR__.'/../framework');

$output = $fw_base.'/out/%s';
$library = $fw_base.'/src/%s';

$components = array(
	'base/core' => array(
		'name' => 'core',
		'phar' => 'ender-core.phar',
		'stub' => '/src/stubs/core.php',
	),
);

foreach ($components as $path => $data) {
	$file = sprintf($output, $data['phar']);
	$base = sprintf($library, $path);

	if (file_exists($file)) unlink($file);
	
	$phar = new Phar($file, FileSystemIterator::CURRENT_AS_FILEINFO | FileSystemIterator::KEY_AS_FILENAME);
	$phar->buildFromDirectory($base);
	$phar->setStub(file_get_contents($fw_base.$data['stub']));


	echo "== Built {$data['name']}", PHP_EOL;
	echo "   From: $path", PHP_EOL;
	echo "   File: ", basename($file), PHP_EOL;
	echo "   Size: ", round(filesize($file)/1024, 2), "Kb", PHP_EOL;
}