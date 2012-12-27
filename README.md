Simple REST crud server.

model objects will share the interface:

```php
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
```

initialize the server mapping the model to the real class names:

```php
<?php
// index.php
use Rest\App;

$app = App::create(new \PDO('sqlite::memory:'));

$app->register('dogs', '\App\Dogs');
$app->register('cats', '\App\Cats');

$app->getResponse()->send();
```

The server will handle GET request to get(), DELETE to delete(), POST to update() and CREATE to create()