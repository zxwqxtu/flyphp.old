<?php
/**
 * Render.php
 *
 * 视图渲染
 *
 * @category Render
 * @package  Response
 * @author   wangqiang <960875184@qq.com>
 * @tag      Response Render
 * @version  GIT: $Id$
 */
namespace FlyPhp\Response;

use FlyPhp\Core\Single;
use FlyPhp\Core\Config;

/**
 * Render.php
 *
 * 视图渲染
 *
 * @category Render
 * @package  Response
 * @author   wangqiang <960875184@qq.com>
 */
class Render
{
    //使用单例
    use Single;

    /** @var array headers */
    protected $headers = array();

    /** @var array response */
    protected $response = array();

    /** @var string viewContent */
    public $viewContent = '';

    /**
     * 设置头部
     *
     * @param string $key   Content-type
     * @param string $value value
     *
     * @return \Response\Render
     */    
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }
    /**
     * 设置头部
     *
     * @param array $headers headers
     *
     * @return \Response\Render
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $k => $v) {
            $this->setHeader($k, $v);
        }

        return $this;
    }

    /**
     * 输出结果
     *
     * @param string $data       数据
     * @param string $viewFile   view 模板
     * @param string $layoutFile layout 模板
     *
     * @return void 
     */
    public function view($data, $viewFile, $layoutFile)
    {
        $this->header(); 
        $this->response = $data;

        ob_start();
        include $viewFile;
        $this->viewContent = ob_get_contents();
        ob_end_clean();

        if (!empty($layoutFile)) {
            include $layoutFile;
        } else {
            echo $this->viewContent;
        }
        exit;
    }

    /**
     * 输出结果
     *
     * @return boolean
     */
    protected function header()
    {
        foreach ($this->headers as $k => $v) {
            header("{$k}: {$v}");
        }
        return true;
    }

    /**
     * 输出结果
     *
     * @param string $data       数据
     * @param bool   $headerFlag 是否输出header
     *
     * @return void 
     */
    public function output($data, $headerFlag=true)
    {
        if (!empty($headerFlag)) {
            $this->header();
        }

        $str = '';
        if (is_array($data) || is_object($data)) {
            $str = json_encode($data);
        } elseif (!is_resource($data)) {
            $str = $data;
        }
        echo $str;
        exit;
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
}

