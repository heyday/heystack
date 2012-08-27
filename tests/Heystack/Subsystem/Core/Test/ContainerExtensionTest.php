<?php

namespace Heystack\Subsystem\Core\Test;

use Heystack\Subsystem\Core\ContainerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-08-22 at 09:40:56.
 */
class ContainerExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerExtension
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ContainerExtension;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->object = null;
    }

    /**
     *
     * @covers Heystack\Subsystem\Core\ContainerExtension::setFolder
     * @covers Heystack\Subsystem\Core\ContainerExtension::getFolder
     */
    public function testSetGetFolder()
    {

        $this->object->setFolder('hello');
        $this->assertEquals('hello', $this->object->getFolder());

    }

    /**
     * @covers Heystack\Subsystem\Core\ContainerExtension::load
     */
    public function testLoad()
    {

        $containerBuilder = new ContainerBuilder();

        $this->object->setFolder('/tests/Heystack/Subsystem/Core/Test/services/');

        $this->object->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->has('example'));

        $this->assertEquals('Test', $containerBuilder->getDefinition('example')->getClass());

    }

    /**
     * @covers Heystack\Subsystem\Core\ContainerExtension::getNamespace
     */
    public function testGetNamespace()
    {
        $this->assertEquals(ContainerExtension::IDENTIFIER, $this->object->getNamespace());
    }

    /**
     * @covers Heystack\Subsystem\Core\ContainerExtension::getXsdValidationBasePath
     */
    public function testGetXsdValidationBasePath()
    {
        $this->assertEquals(false, $this->object->getXsdValidationBasePath());
    }

    /**
     * @covers Heystack\Subsystem\Core\ContainerExtension::getAlias
     */
    public function testGetAlias()
    {
        $this->assertEquals(ContainerExtension::IDENTIFIER, $this->object->getAlias());
    }
}
