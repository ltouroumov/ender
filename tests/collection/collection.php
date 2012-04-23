<?php
require_once __DIR__.'/../lib/ender-core.phar';
use Ender\Util\Collection as Coll;

$hash = new Coll\HashObject();
$hash->set('toto', 'toto');
$hash->set('tata', 'tata');
$hash->set('titi', 'titi');

$list = new Coll\ListObject();
$list->push('foo');
$list->push('bar');

$set  = new Coll\SetObject();
$set->add($obj1 = new StdClass);
$set->add(new StdClass);
$set->add(new StdClass);
$set->add(12345);
$set->add(22345);
$set->add(62345);
$set->add(12345);

echo "== Hash ==", PHP_EOL;
echo 'get: ', $hash->get('toto'), PHP_EOL;
echo 'has: ', $hash->has('titi'), PHP_EOL;
echo 'enum--', PHP_EOL;
echo $hash->each(function($val, $key) {
	echo "$key => $val", PHP_EOL;
})->collect(function($val, $key) {
	return "Foo:$val";
})->reduce(function($data, $val, $key) {
	return ($data !== null ? $data . ", " : '') . $val;
}), PHP_EOL;

echo PHP_EOL, "== List ==", PHP_EOL;
echo 'get: ', $list->get(1), PHP_EOL;
echo 'enum--', PHP_EOL;
echo $list->each(function($val) {
	echo "$val", PHP_EOL;
})->collect(function($val) {
	return "K:$val";
})->reduce(function($data, $val) {
	return ($data !== null ? $data . ', ' : '') . $val;
}), PHP_EOL;

echo PHP_EOL, "== Set ==", PHP_EOL;
echo 'contains: ', $set->contains($obj1), PHP_EOL;
echo 'size: ', $set->size(), PHP_EOL;
echo 'count: ', $set->collect(function($val) {
	return 1;
})->reduce(function($data, $val) {
	return $data + $val;
}, 0), PHP_EOL;

$list = new Coll\ListObject([2,4,6,8,0,1,3,5,7,9]);
$list2 = $list->sort(function($a, $b) { return $a > $b ? 1 : -1; });
echo $list2->join(','), PHP_EOL;

$list = new Coll\ListObject([
	['name' => 'Joa', 'bal' => 1000],
	['name' => 'Jon', 'bal' => 1000],
	['name' => 'Zach', 'bal' => 100]
]);
echo $list->sort('bal, name')->collect(function($val) { return $val['name'].':'.$val['bal']; })->join("\n"), PHP_EOL;