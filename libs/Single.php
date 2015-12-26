<?php
/**
 * Single.php
 *
 * 单列类 
 *
 * @category Single
 * @package  Libs
 * @author   wangqiang <960875184@qq.com>
 * @tag      Libs Single 
 * @version  GIT: $Id$
 */
namespace Libs;

/**
 * Libs\Single
 *
 * 单例类
 *
 * @category Single
 * @package  Libs
 * @author   wangqiang <960875184@qq.com>
 */

abstract class Single
{
    /** @var object|null 实例对象 */
    protected static $instance = null;

    /**
     * 构造函数
     *
     */
    final protected function __construct()
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
        if (empty(self::$instance)) {
            $className = get_called_class();
            self::$instance = new $className();
        }        
        return self::$instance;
    }
}
