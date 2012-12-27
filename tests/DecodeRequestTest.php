<?php

use Symfony\Component\HttpFoundation\Request;
use Rest\Decoder;

class DecodeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function provider()
    {
        return array(
            array(
                'url'      => '/cats/1',
                'method'   => 'GET',
                'expected' => array('model' => 'cats', 'id' => 1, 'action' => 'get', 'parameters' => array())
            ),
            array(
                'url'      => '/dogs/1',
                'method'   => 'GET',
                'expected' => array('model' => 'dogs', 'id' => 1, 'action' => 'get', 'parameters' => array())
            ),
            array(
                'url'      => '/dogs',
                'method'   => 'GET',
                'expected' => array('model' => 'dogs', 'id' => null, 'action' => 'get', 'parameters' => array())
            ),
            array(
                'url'      => '/dogs/1',
                'method'   => 'DELETE',
                'expected' => array('model' => 'dogs', 'id' => 1, 'action' => 'delete', 'parameters' => array())
            ),
            array(
                'url'      => '/dogs/1?name=lassie',
                'method'   => 'UPDATE',
                'expected' => array('model' => 'dogs', 'id' => 1, 'action' => 'update', 'parameters' => array('name' => 'lassie'))
            ),
            array(
                'url'      => '/dogs/2?name=lassie',
                'method'   => 'CREATE',
                'expected' => array('model' => 'dogs', 'id' => 2, 'action' => 'create', 'parameters' => array('name' => 'lassie'))
            ),
        );
    }

    /** @dataProvider provider */
    public function testGetRequestParametersFromRequest($url, $method, $expected)
    {
        $decoder = new Decoder(Request::create($url, $method));
        foreach ($expected['parameters'] as $key => $value) {
            $this->assertEquals($value, $decoder->getRequest()->get($key));
        }
    }

    /** @dataProvider provider */
    public function testGetModelFromRequest($url, $method, $expected)
    {
        $decoder = new Decoder(Request::create($url, $method));
        $this->assertEquals($expected['model'], $decoder->getModel());
    }

    /** @dataProvider provider */
    public function testGetIdFromRequest($url, $method, $expected)
    {
        $decoder = new Decoder(Request::create($url, $method));
        $this->assertEquals($expected['id'], $decoder->getId());
    }

    /** @dataProvider provider */
    public function testGetActionFromRequest($url, $method, $expected)
    {
        $decoder = new Decoder(Request::create($url, $method));
        $this->assertEquals($expected['action'], $decoder->getAction());
    }
}