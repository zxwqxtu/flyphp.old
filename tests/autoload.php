<?php
//框架根路径
define('SYSTEM_PATH', dirname(__DIR__));
define('ROOT_PATH', dirname(SYSTEM_PATH));

//自动注册，包含类所在的文件
require SYSTEM_PATH.'/core/AutoLoader.php';
spl_autoload_register(array(new Core\AutoLoader(),'load'));

