<?php
/**
 * Request.php
 *
 * 请求实例
 *
 * @category Request
 * @package  Request 
 * @author   wangqiang <960875184@qq.com>
 * @tag      Request
 * @version  GIT: $Id$
 */
namespace FlyPhp\Request;

use FlyPhp\Core\Single;

/**
 * Request.php
 *
 * 请求实例
 *
 * @category Request
 * @package  Request 
 * @author   wangqiang <960875184@qq.com>
 */
class Request
{
    //使用单例
    use Single;

    /**
     * 访问$_GET, $_POST, $_FILES, $_COOKIE, $_SESSION
     * 参照get方法
     *
     * @param string $method    调用方法get/post/file
     * @param array  $arguments 方法参数
     *
     * @return string|bool|int|null
     */
    public function __call($method, $arguments)
    {
        $key = $arguments[0];
        $type = $arguments[1];
        $default = isset($arguments[2])? $arguments[2]: null;

        $val = $this->getVariable($method);
        if (!isset($val[$key])) {
            return $this->format($default, $type);
        }
        return $this->format($val[$key], $type);
    }

    /**
     * 获取对应全局变量
     *
     * @param string $method 方法名
     *
     * @return array
     */
    protected function getVariable($method)
    {
        switch($method) {
        case 'get':
            return $_GET;
        case 'post':
            return $_POST;
        case 'server':
            return $_SERVER;
        case 'files':
            return $_FILES;
        case 'session':
            session_status() != PHP_SESSION_ACTIVE && session_start();
            return $_SESSION;
        case 'cookie':
            return $_COOKIE;
        case 'request':
            return $_REQUEST;
        case 'env':
            return $_ENV;
        default:
            return $$method;
        }
    }

    /**
     * Get方法
     *
     * @param string $key     key
     * @param string $type    type
     * @param string $default default 
     *
     * @return string|bool|int|null
     */
    public function get($key, $type, $default=null)
    {
        if (!isset($_GET[$key])) {
            return $this->format($default, $type);
        }
        return $this->format($_GET[$key], $type);
    }

    /**
     * 格式化字符
     *
     * @param string $val  val
     * @param string $type type
     *
     * @return string|bool|int|null
     */
    public function format($val, $type='string')
    {
        switch($type) {
        case 'string':
            return strval($val);
        case 'int':
            return intval($val);
        case 'bool':
            return !empty($val);
        case 'float':
            return floatval($val);
        case 'array':
            return empty($val)? array(): $val;
        default:
            return $val;
        }
    }
}
