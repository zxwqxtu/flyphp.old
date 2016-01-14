<?php

namespace CoreTest;
use Core\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected $testFile = 'xsdfskkk';

    protected function setUp()
    {
        $config = array(
            'k' => 'v',
            'kkk' => array('vvv'),
            'debug' => true
        );

        $file = SYSTEM_PATH."/config/{$this->testFile}.php";
        file_put_contents($file, "<?php return ".var_export($config, true).";");

        $file = ROOT_PATH."/app/config/{$this->testFile}.php";
        file_put_contents($file, "<?php return ".var_export($config, true).";");
    }

    protected function tearDown()
    {
        $file = SYSTEM_PATH."/config/{$this->testFile}.php";
        unlink($file);

        $file = ROOT_PATH."/app/config/{$this->testFile}.php";
        unlink($file);
    }

    /**
     * @dataProvider provider
     */
    public function testGet($key, $item=null)
    {
        $this->assertNull(Config::get($key, $item));   
    }

    public function testLoad()
    {
        $this->assertArrayHasKey('k', Config::load($this->testFile));

        $arr = Config::load($this->testFile);
        $this->assertEquals(array('vvv'), $arr['kkk']);

        $arr = Config::load('config', true);
        $this->assertLessThan(count($arr['importClassPath']), 3);

        $this->assertEmpty(Config::load('xsfskfs'));
    }

    public function testGetByFile()
    {
        $this->assertNotNull(Config::getByFile(SYSTEM_PATH, $this->testFile));
    }

    public function testGetSystem()
    {
        $this->assertFalse(Config::getSystem('debug'));
    }
 
    public function testGetAppRoot()
    {
        $this->assertNull(Config::getAppRoot('debug', 'iuyfttds'));
        $this->assertTrue(Config::getAppRoot('debug', $this->testFile));
    }

    public function testGetApp()
    {
        $this->assertNull(Config::getApp('debug', 'iuyfttds'));
    }
      
    public function provider()
    {
        return array(
            array('key'), 
            array('key', 'item')
        );
    }
}