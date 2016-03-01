<?php
/**
 * Config.php
 *
 * 配置文件类
 *
 * @category Config 
 * @package  Core 
 * @author   wangqiang <960875184@qq.com>
 * @tag      Config 
 * @version  GIT: $Id$
 */
namespace FlyPhp\Core;

/**
 * Core\Config
 *
 * 配置文件类
 *
 * @category Config
 * @package  Core 
 * @author   wangqiang <960875184@qq.com>
 */
class Config 
{    
    /** @var array 配置数组 */
    private static $_config = array();

    /**
     * 获取config.php文件值
     *
     * @param string $key    key
     * @param string $item   item 
     *
     * @return string|int|array|null
     */
    public static function get($key=null, $item=null)
    {
        return self::config($key, $item);
    }

    /**
     * 设置config属性
     *
     * @param string $file      文件前缀名
     * @param bool   $recursive 是否用array_merge_recursive
     *
     * @return array
     */
    public static function load($file = 'config', $recursive = false)
    {
        $files = array(
            SYSTEM_PATH.DIRECTORY_SEPARATOR."config/{$file}.php",
            ROOT_PATH.DIRECTORY_SEPARATOR."config/{$file}.php",
        );
        if (defined('APP_PATH')) {
            $files[] = APP_PATH.DIRECTORY_SEPARATOR."config/{$file}.php";
        }

        $config = array();
        $func = $recursive ? 'array_merge_recursive': 'array_merge';

        foreach ($files as $v) {
            if (!file_exists($v)) {
                continue;
            }
            $config = call_user_func($func, $config, include $v);
        }

        return $config;
    }

    /**
     * 魔术方法
     * 获取配置信息
     *
     * @param string $name      method name
     * @param array  $arguments 魔术方法参数 
     *
     * @return string|int|array|null
     */
    public static function __callStatic($name, $arguments)
    {
        if (!defined('APP_PATH')) {
            $config = self::load($name);
        } elseif (empty(self::$_config[$name])) {
            $config = self::$_config[$name] = self::load($name);
        } else {
            $config = self::$_config[$name];
        }

        $key = empty($arguments[0]) ? null : $arguments[0];
        $item = empty($arguments[1]) ? null : $arguments[1];
        if (empty($key)) {
            return $config;
        }
        if (empty($item)) {
            return isset($config[$key])? $config[$key]: null;
        }

        return isset($config[$key][$item])? $config[$key][$item]: null;
    }

    /**
     * 获取配置文件内容
     *
     * @param string $fileDir 文件目录
     * @param string $file    文件
     *
     * @return array|null;
     */
    public static function getByFile($fileDir, $file='config')
    {
        $file = $fileDir. "/config/{$file}.php";
        if (file_exists($file)) {
            return include $file;
        }

        return null;
    }

    /**
     * 获取框架配置文件内容
     *
     * @param string $item item
     * @param string $file 文件
     *
     * @return array|string|null;
     */
    public static function getSystem($item, $file='config')
    {
        $config = self::getByFile(SYSTEM_PATH, $file);

        return isset($config[$item])? $config[$item]: null;
    }

    /**
     * 获取根目录配置文件内容
     *
     * @param string $item item
     * @param string $file 文件
     *
     * @return array|string|null;
     */
    public static function getRoot($item, $file='config')
    {
        $config = self::getByFile(ROOT_PATH, $file);

        return isset($config[$item])? $config[$item]: null;
    }

    /**
     * 获取APP目录配置文件内容
     *
     * @param string $item item
     * @param string $file 文件
     *
     * @return array|string|null;
     */
    public static function getApp($item, $file='config')
    {
        if (!defined('APP_PATH')) {
            return null;
        }
        $config = self::getByFile(APP_PATH, $file);

        return isset($config[$item])? $config[$item]: null;
    }
}
