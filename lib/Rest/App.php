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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Rest\Decoder;

class App
{
    public static function create(\PDO $pdo)
    {
        return new self(new Decoder(Request::createFromGlobals()), $pdo);
    }

    private $decoder;
    private $pdo;
    private $maps = array();

    public function __construct(Decoder $decoder, \PDO $pdo)
    {
        $this->decoder = $decoder;
        $this->pdo     = $pdo;
    }

    public function register($name, $class)
    {
        $this->maps[$name] = $class;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        $response = new Response();
        try {
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($this->run());
            $response->setStatusCode(200);
        } catch (Exception $e) {
            $response->setContent($e->getMessage());
            $response->setStatusCode($e->getCode());
        }

        return $response;
    }

    private function run()
    {
        if (is_null($this->decoder->getId())) {
            $out = call_user_func_array(array($this->getClassFromModel(), Decoder::ACTION_GETALL), array($this->decoder->getRequest()));
        } else {
            $object = $this->getNewInstance($this->decoder->getId(), $this->getClassFromModel());
            $out    = array();
            switch ($this->decoder->getAction()) {
                case Decoder::ACTION_GET:
                    $out = $object->get();
                    break;
                case Decoder::ACTION_DELETE:
                    $out = $object->delete();
                    break;
                case Decoder::ACTION_UPDATE:
                    $out = $object->update($this->decoder->getRequest());
                    break;
                case Decoder::ACTION_CREATE:
                    $out = $object->create($this->decoder->getRequest());
                    break;
                default:
                    throw new Exception('Not a valid action', 404);
            }
        }


        return json_encode($out);
    }

    private function getClassFromModel()
    {
        $model = $this->decoder->getModel();
        if (array_key_exists($model, $this->maps)) {
            return $this->maps[$model];
        } else {
            throw new Exception('Not a valid model', 404);
        }
    }

    /**
     * @param $id
     * @param $class
     * @return \Rest\Iface
     */
    private function getNewInstance($id, $class)
    {
        return new $class($id, $this->pdo);
    }
}