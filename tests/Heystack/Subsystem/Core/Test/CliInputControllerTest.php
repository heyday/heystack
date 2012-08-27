<?php

namespace Heystack\Subsystem\Core\Test;

use Heystack\Subsystem\Core\Input\Handler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-08-22 at 15:44:53.
 */
class CliInputControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CliInputController
     */
    protected $object;

    protected $inputHandler;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

        $this->inputHandler = new Handler;
        $processor = new TestInputProcessor('test_input_processor', 'Hello');
        $this->inputHandler->addProcessor($processor);

        $this->object = new \CliInputController;
        $this->object->setInputHandlerService($this->inputHandler);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->object = null;
        $this->inputHandler = null;
    }

    /**
     * @covers CliInputController::process
     */
    public function testProcess()
    {
        $request = new \SS_HTTPRequest('GET', 'process/test_input_processor');
        $request->match('$Action/$Processor/$ID/$OtherID/$ExtraID');
        $this->assertEquals('Hello', $this->object->handleRequest($request)->getBody());
        $this->assertNotEquals('Hello2', $this->object->handleRequest($request)->getBody());
    }

    public function testConstruct()
    {

        $controller = new \CliInputController;
        $this->assertInternalType('object', $controller);

    }

    public function testSetGetInputHandlerService()
    {
        $controller = new \CliInputController;

        $controller->setInputHandlerService($this->inputHandler);

        $this->assertEquals($this->inputHandler, $controller->getInputHandlerService());
    }
}
