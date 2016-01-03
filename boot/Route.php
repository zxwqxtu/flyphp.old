<?php
/**
 * Route.php
 *
 * 路由类
 *
 * @category Route
 * @package  Boot
 * @author   wangqiang <960875184@qq.com>
 * @tag      Boot Route 
 * @version  GIT: $Id$
 */
namespace Boot;

use Core\Single;
use Core\Config;

/**
 * Boot\Route
 *
 * 路由类
 *
 * @category Route
 * @package  Boot
 * @author   wangqiang <960875184@qq.com>
 */
class Route
{
    //使用单例
    use Single;
    /**
     * @var array 路由器组
     */
    private $_route = array();
    /**
     * @var string 控制器
     */
    private $_controller = '';
    /**
     * @var string action
     */
    private $_action = '';
    /**
     * @var array 传入action方法的参数
     */
    private $_params = array();

    /**
     * @var string appName
     */
    private $_appName= '';

    /**
     * 初始化运行
     */
    protected function init()
    {
        //命令行运行
        if (php_sapi_name() == 'cli') {
            if (empty($_SERVER['argv'][1])) {
                throw new \Exception('UNDEFINED-APPNAME');
            }

            $this->_appName = $_SERVER['argv'][1];

            $tmp = $_SERVER['argv'];
            unset($tmp[1]);
            $this->_route = array_values($tmp);
            //绝对路径换成index.php
            $this->_route[0] = 'index.php';

        } else {
            $this->_appName = Config::get('app', $_SERVER['HTTP_HOST']);

            $this->_route = explode('/', $_SERVER['PHP_SELF']);
        }

        $this->urlToClass();
    }

    /**
     * 路由到控制器
     *
     * @return void
     */
    final public function urlToClass()
    {
        $routeArr = $this->_route;
        $indexKey = array_search('index.php', $routeArr);
        //采用默认crontroller action
        if ($indexKey === false) {
            return false;
        }

        isset($routeArr[$indexKey+1]) && ($this->_controller = $routeArr[$indexKey+1]);
        isset($routeArr[$indexKey+2]) && ($this->_action = $routeArr[$indexKey+2]);
        isset($routeArr[$indexKey+3]) && ($this->_params = array_slice($routeArr, $indexKey+3));

        $this->_controller = $this->seoUrl($this->_controller);
        $this->_action = $this->seoUrl($this->_action);
    }

    /**
     * 优化seoUrl
     *
     * @param string $url controller action
     *
     * @return string
     */
    protected function seoUrl($url)
    {
        if (empty($url)) {
            return $url;
        }
        //转换index.php/admin-login/index  
        //index.php/adminLogin/index 
        //index.php/admin_login/index
        $url = preg_replace_callback(
            '#[\-\_]([a-z])#', 
            function ($match) {
                return strtoupper($match[1]);
            },
            $url
        );
        return $url;
    }

    /**
     * 获取controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * 获取action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * 获取参数
     *
     * @return string
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * 获取app名
     *
     * @return string
     */
    public function getAppName()
    {
        return $this->_appName;
    }
}
