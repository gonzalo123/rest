<?php

use Symfony\Component\HttpFoundation\Request;
use Rest\App;

class AppIntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testAppUnvalidModel()
    {
        $decoder = $this->getMockBuilder('Rest\Decoder')->disableOriginalConstructor()->getMock();
        $decoder->expects($this->any())->method('getModel')->will($this->returnValue('dogs'));
        $decoder->expects($this->any())->method('getId')->will($this->returnValue(1));
        $decoder->expects($this->any())->method('getAction')->will($this->returnValue('get'));

        $app      = new App($decoder, new \PDO('sqlite::memory:'));
        $response = $app->getResponse();

        $this->assertEquals('Not a valid model', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testAppUnvalidAction()
    {
        include __DIR__ . '/fixtures/Dogs.php';

        $decoder = $this->getMockBuilder('Rest\Decoder')->disableOriginalConstructor()->getMock();
        $decoder->expects($this->any())->method('getModel')->will($this->returnValue('dogs'));
        $decoder->expects($this->any())->method('getId')->will($this->returnValue(1));
        $decoder->expects($this->any())->method('getAction')->will($this->returnValue('xxx'));

        $app = new App($decoder, new \PDO('sqlite::memory:'));
        $app->register('dogs', '\App\Dogs');
        $response = $app->getResponse();

        $this->assertEquals('Not a valid action', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testApp()
    {
        include_once __DIR__ . '/fixtures/Dogs.php';

        $decoder = $this->getMockBuilder('Rest\Decoder')->disableOriginalConstructor()->getMock();
        $decoder->expects($this->any())->method('getModel')->will($this->returnValue('dogs'));
        $decoder->expects($this->any())->method('getId')->will($this->returnValue(1));
        $decoder->expects($this->any())->method('getAction')->will($this->returnValue('get'));

        $app = new App($decoder, new \PDO('sqlite::memory:'));
        $app->register('dogs', '\App\Dogs');
        $response = $app->getResponse();

        $this->assertEquals(json_encode(array(1, 2, 3), true), $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}