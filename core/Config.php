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
namespace Core;

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
    private static $_config = null;

    /**
     * 获取config文件值
     *
     * @param string $key    key
     * @param string $item   item 
     *
     * @return string|int|array|null
     */
    public static function get($key=null, $item=null)
    {
        if (!defined('APP_PATH')) {
            $config = self::getAll();
        } elseif (empty(self::$_config)) {
            $config = self::$_config = self::getAll();
        } else {
            $config = self::$_config;
        }

        if (empty($key)) {
            return $config;
        }
        if (empty($item)) {
            return isset($config[$key])? $config[$key]: null;
        }

        return isset($config[$key][$item])? $config[$key][$item]: null;
    }

    /**
     * 设置config属性
     *
     * @return array
     */
    public static function getAll()
    {
        $files = array(
            SYSTEM_PATH.DIRECTORY_SEPARATOR.'config.php',
            ROOT_PATH.DIRECTORY_SEPARATOR.'app/config.php',
        );
        if (defined('APP_PATH')) {
            $files[] = APP_PATH.DIRECTORY_SEPARATOR.'config.php';
        }

        $config = array();
        foreach ($files as $v) {
            if (!file_exists($v)) {
                continue;
            }
            $config = array_merge($config, include $v);
        }

        return $config;
    }
}
