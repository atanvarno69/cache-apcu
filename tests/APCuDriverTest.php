<?php
/**
 * @package   Atanvarno\Cache-APCu
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atanvarno\Cache\Apcu\Test;

/** PHP Unit use block. */
use PHPUnit\Framework\TestCase;

/** Package use block. */
use Atanvarno\Cache\{
    Driver, Apcu\APCuDriver
};

class APCuDriverTest extends TestCase
{
    /** @var APCuDriver $driver */
    private $driver;

    public function setUp()
    {
        $this->driver = new APCuDriver();
    }

    public function tearDown()
    {
        apcu_clear_cache();
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(Driver::class, $this->driver);
    }

    public function testGet()
    {
        apcu_store('value1', 'test string');
        $result = $this->driver->get('value1');
        $this->assertSame('test string', $result);
    }

    public function testGetWithDefault()
    {
        $result = $this->driver->get('value1', 'default value');
        $this->assertSame('default value', $result);
    }

    public function testSet()
    {
        $result = $this->driver->set('value1', 'test string');
        $this->assertTrue(apcu_exists('value1'));
        $this->assertTrue($result);
    }

    public function testSetWithTtl()
    {
        $result = $this->driver->set('value1', 'test string', 1);
        $this->assertTrue(apcu_exists('value1'));
        $this->assertTrue($result);
    }

    public function testDelete()
    {
        apcu_store('value1', 'test string');
        apcu_store('value2', 'test string');
        $result = $this->driver->delete('value1');
        $this->assertFalse(apcu_exists('value1'));
        $this->assertTrue(apcu_exists('value2'));
        $this->assertTrue($result);
    }

    public function testClear()
    {
        apcu_store('value1', 'test string');
        apcu_store('value2', 'test string');
        $result = $this->driver->clear();
        $this->assertFalse(apcu_exists('value1'));
        $this->assertFalse(apcu_exists('value2'));
        $this->assertTrue($result);
    }

    public function testHas()
    {
        apcu_store('value', 'test string');
        $this->assertTrue($this->driver->has('value'));
        $this->assertFalse($this->driver->has('non-value'));
    }
}
