<?php
require_once __DIR__.'/../lib/ender-core.phar';
use Ender\Util;

$coll = new Util\MetaCollection();
$coll->set('hello', 'world', ['type' => '@world']);

var_dump($coll->get('hello'), $coll->metaGet('hello'));