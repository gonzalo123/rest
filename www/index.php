<?php
include __DIR__ . "/../vendor/autoload.php";
error_reporting(-1);

use Rest\App;

$app = App::create(new \PDO('sqlite::memory:'));

$app->register('dogs', '\App\Dogs');
$app->register('cats', '\App\Cats');

$app->getResponse()->send();