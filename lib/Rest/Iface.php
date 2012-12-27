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

interface Iface
{
    public function __construct($id, \PDO $pdo);

    public function get();

    public function delete();

    public function update(Request $request);

    public function create(Request $request);

    public static function getAll(Request $request);
}