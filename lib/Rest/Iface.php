<?php

namespace Rest;

use \Symfony\Component\HttpFoundation\Request;

interface Iface
{
    public function __construct($id, \PDO $pdo);

    public function get();

    public function delete();

    public function update(Request $request);

    public function create(Request $request);
}