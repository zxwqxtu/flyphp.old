<?php
/**
 * Base.php
 *
 * 控制器base
 *
 * @category Base
 * @package  Controllers
 * @author   wangqiang <960875184@qq.com>
 * @tag      Controllers Base
 * @version  GIT: $Id$
 */
namespace FlyPhp\Controllers;

use FlyPhp\Core\Config;
use FlyPhp\Request\Request;

/**
 * Base.php
 *
 * 控制器base
 *
 * @category Base
 * @package  Controllers
 * @author   wangqiang <960875184@qq.com>
 */
abstract class Base
{
    /** @var string view文件的后缀名 */
    protected $viewSuffix = '.php';

    /** @var string view内容 */
    protected $viewContent = '';

    /** @var string 布局文件 */
    protected $layout = '';

    /** @var string 主题布局文件 */
    protected $theme = '';

    /** @var string 模板 */
    protected $view = '';

    /** @var string 默认Action */
    protected $defaultAction = 'index';

    /** @var string 模板内容 */
    protected $response = array();

    /** @var array 头部 */
    protected $headers = array();

    /** @var array 头部 */
    protected $request = null;

    /**
     * 构造函数，不能被继承
     */
    final public function __construct()
    {
        $this->request = Request::getInstance();

        $this->beforeInit();
        $this->init();
    }

    /**
     * 执行初始化之前
     *
     * @return bool 
     */
    protected function beforeInit()
    {
        return true;
    }

    /**
     * 初始化
     *
     * @return void
     */
    protected function init()
    {
        $this->setErrorHandler();
    }

    /**
     * 错误处理方式
     *
     * @return void
     */
    final protected function setErrorHandler()
    {
        return register_shutdown_function(array($this, 'errorHandler'));
    }

    /**
     * 错误处理方式
     *
     * @return void
     */
    public function errorHandler()
    {

    }

    /**
     * 获取默认action
     *
     * @return string action
     */
    final public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * 获取config文件值
     *
     * @param string $key  key
     * @param string $item item 
     *
     * @return string|int|array|null
     */
    public function getConfig($key=null, $item=null)
    {
        return Config::get($key, $item);
    }

    /**
     * 获取view File
     *
     * @return string
     */
    final public function getViewFile()
    {
        $fileName = APP_PATH.DIRECTORY_SEPARATOR.'views'; 
        $fileName .= DIRECTORY_SEPARATOR.$this->view.$this->viewSuffix;
        if (!file_exists($fileName)) {
            throw new \Exception("tpl:{$fileName} not exist!");
            return null;
        }

        return $fileName;
    }

    /**
     * 获取layout File
     *
     * @return string
     */
    final function getLayoutFile()
    {
        if (empty($this->layout)) {
            return null;
        }

        $fileName = APP_PATH.DIRECTORY_SEPARATOR.'layouts';
        if (!empty($this->theme)) {
            $fileName .= DIRECTORY_SEPARATOR.$this->theme;
        }
        $fileName .= DIRECTORY_SEPARATOR.$this->layout.$this->viewSuffix;

        if (!file_exists($fileName)) {
            throw new \Exception("LAYOUT-NO-EXISTS:{$fileName}");
            return null;
        }
        return $fileName;
    }

    /**
     * 获取头部headers
     *
     * @return array
     */
    final function getHeaders()
    {
        $charset = $this->getConfig('charset');

        $this->headers = array_merge(
            array('Content-type' => "text/html; charset={$charset}"),
            $this->headers 
        );

        return $this->headers;
    }
    /**
     * 获取view
     *
     * @return string
     */
    final public function getView()
    {
        return $this->view;
    }
}
