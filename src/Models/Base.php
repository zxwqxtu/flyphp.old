<?php
/**
 * Base.php
 *
 * Model base
 *
 * @category Base
 * @package  Models
 * @author   wangqiang <960875184@qq.com>
 * @tag      Models Base
 * @version  GIT: $Id$
 */
namespace FlyPhp\Models;

use FlyPhp\Core\Config;
use FlyPhp\Core\Single;

/**
 * Base.php
 *
 * 模型base
 *
 * @category Base
 * @package  Models
 * @author   wangqiang <960875184@qq.com>
 */
abstract class Base
{
    //使用单例
    use Single;

    /** @var string 数据库类型 */
    protected $dbType = 'mysql';

    /** @var string 数据库配置 */
    protected $dbSelect= 'default';

    /** @var object 数据库 */
    protected $db = null;
    
    /**
     * 初始化
     *
     * @return void
     */
    protected function init()
    {
        $config = Config::database($this->dbType, $this->dbSelect);

        switch ($this->dbType) {
        case 'mongodb':
            $dbClass = '\PhpDb\Mongodb\PhpMongo';
            break;
        default:
            $dbClass = '\PhpDb\Pdo\PhpPdo';
        } 

        $this->db = $dbClass::getInstance()->connect($config, $this->dbType);
    }
}
