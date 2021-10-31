<?php

$name = 'nanopk';
echo($name . ' version: ' . phpversion($name) . "\n");
echo('PHP version: ' . PHP_VERSION . "\n");


$fs = ['time', 'nanotime', 'nanopk', 'uptime', 'rdtscp', 'nanopkavg', 'nanotime_array'];
foreach($fs as $f) var_dump($f());
var_dump(nanopk(NANOPK_VERSION));

if (1) {
	$args = [
		0,
		NANOPK_U,
		NANOPK_TSC,
		NANOPK_PID | NANOPK_UNS,
		NANOPK_ALL
		];

	foreach($args as $a) var_dump(nanopk($a));
}

echo('PHP version: ' . PHP_VERSION . "\n");
echo('test version: 0.3.2, 5:41pm' . "\n");