<?php

namespace Heystack\Core\Loader;

class DBClosureLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Heystack\Core\Loader\DBClosureLoader::__construct
     */
    public function testCanConstructWithValidArguments()
    {
        $this->assertTrue(
            is_object(
                new DBClosureLoader(function () {})
            )
        );
    }

    /**
     * @covers \Heystack\Core\Loader\DBClosureLoader::__construct
     * @covers \Heystack\Core\Loader\DBClosureLoader::load
     * @expectedException InvalidArgumentException
     */
    public function testExceptionThrownOnLoadEmpty()
    {
        $s = new DBClosureLoader(function () { });

        $s->load(false);
    }

    /**
     * @covers \Heystack\Core\Loader\DBClosureLoader::__construct
     * @covers \Heystack\Core\Loader\DBClosureLoader::supports
     */
    public function testSupportsDataList()
    {
        $s = new DBClosureLoader(function () { });

        $dataList = $this->getMockBuilder('DataList')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertTrue($s->supports($dataList));
        $this->assertFalse(false);
    }
} 