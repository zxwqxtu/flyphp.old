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
namespace Controllers;

use Libs\Common;

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

    /**
     * 构造函数，不能被继承
     */
    final public function __construct()
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
        return Common::getConfig($key, $item);
    }

    /**
     * 输出结果
     *
     * @param string $action method方法
     * @param array  $params method方法的参数
     *
     * @return void 
     */
    final public function output($action, array $params = array())
    {
        $charset = $this->getConfig('charset');
        header("Content-type: text/html; charset={$charset}");

        $ret = call_user_func_array(array($this, $action), $params);
        //函数如果没有return，则返回的是null
        if (is_array($ret) || is_object($ret)) {
            exit(json_encode($ret));
        } elseif (is_string($ret)) {
            exit($ret);
        } elseif (!is_null($ret)) {
            exit; 
        }

        $fileName = APP_PATH.DIRECTORY_SEPARATOR.'views'; 
        if (empty($this->view)) {
            $fileName .= str_replace(
                array("\\", 'Controllers'), 
                array(DIRECTORY_SEPARATOR, ''), 
                get_class($this)
            ); 
            $fileName .= DIRECTORY_SEPARATOR.$action.$this->viewSuffix;
        } else {
            $fileName .= DIRECTORY_SEPARATOR.$this->view.$this->viewSuffix;
        }
        if (!file_exists($fileName)) {
            throw new \Exception("tpl:{$fileName} not exist!");
            return false;
        }

        ob_start();
        include $fileName;
        $this->viewContent = ob_get_contents();
        ob_end_clean();
        
        //加载布局
        if (!empty($this->layout)) {
            $fileName = APP_PATH.DIRECTORY_SEPARATOR.'layouts';
            if (!empty($this->theme)) {
                $fileName .= DIRECTORY_SEPARATOR.$this->theme;
            }
            $fileName .= DIRECTORY_SEPARATOR.$this->layout.$this->viewSuffix;

            include $fileName;
        } else {
            echo $this->viewContent;
        }
        exit;
    }
}
