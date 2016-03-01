#!/usr/bin/env php
<?php
if (empty($_SERVER['argv'][1])) {
    exit("please input appName!".PHP_EOL);
}

$appName = $_SERVER['argv'][1];

$appPath = dirname(dirname(__DIR__))."/app/{$appName}";

$pathes = array('src/Controllers', 'src/Models', 'views', 'layouts', 'config');
foreach ($pathes as $v) {
    $path = $appPath."/{$v}";
    !is_dir($path) && mkdir($path, 0777, true);
}
