<?php

use Core\Database\Database;
use Core\Database\OrderBy;
use Core\Routing\Router;

require __DIR__ . '/../core/autoloader.php';

Database::configure([
    'database' => 'mvc-propose-01'
]);

echo Database::table('products')
    ->insert([
        'name' => 'uadasda'
    ]);