<?php
/**
 * Single.php
 *
 * 单列类 
 *
 * @category Single
 * @package  Core
 * @author   wangqiang <960875184@qq.com>
 * @tag      Core Single 
 * @version  GIT: $Id$
 */
namespace FlyPhp\Core;

/**
 * Core\Single
 *
 * 单例类
 *
 * @category Single
 * @package  Core 
 * @author   wangqiang <960875184@qq.com>
 */

Trait Single
{
    /** @var array 实例对象 */
    private static $_instance = array();

    /**
     * 构造函数
     *
     */
    final private function __construct()
    {
        $this->init();
    }

    /**
     * 初始化
     *
     * @return void
     */
    protected function init()
    {

    }

    /**
     * 实例化
     *
     * @return \Boot\Init
     */
    final public static function getInstance()
    {
        $className = get_called_class();

        if (empty(self::$_instance[$className])) {
            self::$_instance[$className] = new $className();
        }        
        return self::$_instance[$className];
    }
}
