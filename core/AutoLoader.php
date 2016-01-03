<?php
/**
 * AutoLoader.php
 *
 * 类自动加载
 *
 * @category AutoLoader
 * @package  Core 
 * @author   wangqiang <960875184@qq.com>
 * @tag      AutoLoader
 * @version  GIT: $Id$
 */
namespace Core;

/**
 * Core\AutoLoader
 *
 * 自动加载类
 *
 * @category AutoLoader
 * @package  Core
 * @author   wangqiang <960875184@qq.com>
 */
class AutoLoader
{
    /**
     * 加载文件
     *
     * @param string $className 类名
     *
     * @return boolean
     */
    public function load($className)
    {
        $arr = explode('\\', $className);
        $class = array_pop($arr);

        //加载框架
        if ($this->loadSystem($class)) {
            return true;
        }

        //加载app定义类
        if ($this->loadApp($class)) {
            return true;
        }

        //如果没有导入的目录，则按默认规则
        array_walk(
            $arr, 
            function (&$item) {
                $item = lcfirst($item);
            }
        );
        $arr[] = "{$class}.php";
        $file = implode(DIRECTORY_SEPARATOR, $arr);

        $file = ROOT_PATH.DIRECTORY_SEPARATOR.$file;
        if (!file_exists($file)) {
            return false;
        }

        require_once $file;
        return true;
    }

    /**
     * 加载框架核心类
     *
     * @param string $class 类名
     *
     * @return boolean
     */
    public function loadSystem($class)
    {
        $config = include SYSTEM_PATH.DIRECTORY_SEPARATOR.'config.php';
        $classDirs = empty($config['importClassPath'])? array(): $config['importClassPath'];
        foreach ($classDirs as $v) {
            $file = SYSTEM_PATH.DIRECTORY_SEPARATOR.$v.DIRECTORY_SEPARATOR.$class.".php";
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }

        return false;
    }

    /**
     * 加载app类
     *
     * @param string $class 类名
     *
     * @return boolean
     */
    public function loadApp($class)
    {
        if (!defined('APP_PATH')) {
            return false;
        }
        $dirs = array();

        $file = SYSTEM_PATH.DIRECTORY_SEPARATOR.'config.php';
        if (file_exists($file)) {
            $config = include $file;
            if (!empty($config['importClassPath'])) {
                $dirs = array_merge($dirs, $config['importClassPath']);
            }
        }

        $file = ROOT_PATH.DIRECTORY_SEPARATOR.'app/config.php';
        if (file_exists($file)) {
            $config = include $file;
            if (!empty($config['importClassPath'])) {
                $dirs = array_merge($dirs, $config['importClassPath']);
            }
        }

        $file = APP_PATH.DIRECTORY_SEPARATOR.'config.php';
        if (file_exists($file)) {
            $config = include $file;
            if (!empty($config['importClassPath'])) {
                $dirs = array_merge($dirs, $config['importClassPath']);
            }
        }

        foreach ($dirs as $v) {
            $file = APP_PATH.DIRECTORY_SEPARATOR.$v.DIRECTORY_SEPARATOR.$class.".php";
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }

        return false;
    }
}
