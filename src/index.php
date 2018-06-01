<?php

include(__DIR__ . '/autoloader.php');

define('DIR_RES', dirname(__DIR__) . '/res/');

$App = new \TC\Otravo\App\App();
$App->run();
