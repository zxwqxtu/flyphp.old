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
namespace FlyPhp\Core;

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
    public function loadApp($className)
    {
        $arr = explode('\\', $className);
        $arr[0] = APP_PATH.'/src'; 
        $file = implode(DIRECTORY_SEPARATOR, $arr).".php";

        if (!file_exists($file)) {
            return false;
        }

        require_once $file;
        return true;
    }
}
