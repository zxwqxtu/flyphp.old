<?php
/**
 * Common.php
 *
 * 公共方法类
 *
 * @category Common
 * @package  Libs
 * @author   wangqiang <960875184@qq.com>
 * @tag      AutoLoader
 * @version  GIT: $Id$
 */
namespace Libs;

/**
 * Common
 *
 * 公共方法类
 *
 * @category Common
 * @package  Libs
 * @author   wangqiang <960875184@qq.com>
 */
class Common
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
    public static function getConfig($key=null, $item=null)
    {
        if (!defined('APP_PATH')) {
            $config = self::getConfigAll();
        } elseif (empty(self::$_config)) {
            $config = self::$_config = self::getConfigAll();
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
    public static function getConfigAll()
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
