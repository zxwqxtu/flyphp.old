#!/usr/bin/php
<?php
if (empty($_SERVER['argv'][1])) {
    exit("please input appName!".PHP_EOL);
}

$appName = $_SERVER['argv'][1];

$appPath = dirname(dirname(__DIR__))."/app/{$appName}";

$pathes = array('controllers', 'models', 'views', 'layouts', 'config');
foreach ($pathes as $v) {
    $path = $appPath."/{$v}";
    !is_dir($path) && mkdir($path, 0777, true);
}
