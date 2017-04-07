<?php
use Tracy\Debugger;

require __DIR__ . '/../vendor/autoload.php';
$config = __DIR__ . '/config.php';
if (!is_file($config)) {
	echo "File config.php is missing. Please copy config.example.php to config.php and set clientId and clientSecret.";
	die;
}
require $config;
//enable debugger
Debugger::enable();
Debugger::$maxDepth = 10;
//autoload all classes
function bar($var, $title = NULL, array $options = NULL)
{
	Debugger::barDump($var, $title, $options);
}
