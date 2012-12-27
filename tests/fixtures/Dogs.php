<?php

namespace App;

use \Symfony\Component\HttpFoundation\Request;

class Dogs implements \Rest\Iface
{
    private $pdo;
    private $id;

    public function __construct($id, \PDO $pdo)
    {
        $this->id = $id;
    }

    public function get()
    {
        return array(1, 2, 3);
    }

    public function delete()
    {
        return array(1, 2, 3);
    }

    public function update(Request $request)
    {
        return array(1, 2, 3);
    }

    public function create(Request $request)
    {
        return array(1, 2, 3);
    }
}