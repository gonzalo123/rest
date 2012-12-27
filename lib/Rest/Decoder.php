<?php

/*
 * This file is part of the gonzalo123/rest package.
 *
 * (c) Gonzalo Ayuso <gonzalo123@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rest;

use \Symfony\Component\HttpFoundation\Request;

class Decoder
{
    private $request;
    private $model;
    private $id;
    private $action;
    private $parameters;

    const ACTION_GET    = 'get';
    const ACTION_GETALL = 'getAll';
    const ACTION_DELETE = 'delete';
    const ACTION_UPDATE = 'update';
    const ACTION_CREATE = 'create';

    private $actionDict = array(
        'GET'    => self::ACTION_GET,
        'DELETE' => self::ACTION_DELETE,
        'UPDATE' => self::ACTION_UPDATE,
        'CREATE' => self::ACTION_CREATE,
        );

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->decode();
    }

    public function getRequest()
    {
        return $this->request;
    }

    private function decode()
    {
        $info        = explode('/', $this->request->getPathInfo());
        $this->model = $info[1];
        $this->id    = isset($info[2]) ? $info[2] : null;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAction()
    {
        return $this->actionDict[$this->request->getMethod()];
    }

    public function run()
    {

    }
}