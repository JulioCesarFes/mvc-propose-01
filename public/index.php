<?php

use Core\Routing\Router;

require __DIR__ . '/../core/autoloader.php';

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'mvc-propose-01');

\Core\View\Views::setPath(__DIR__ . '/../resources/views');

$router = new Router();

$router->register('/', 'get', 'App\Controller\ProductsController', 'index');
$router->register('/produtos', 'get', 'App\Controller\ProductsController', 'index');
$router->register('/novo-produto', 'get', 'App\Controller\ProductsController', 'new');
$router->register('/criar-produto', 'post', 'App\Controller\ProductsController', 'create');
$router->register('/apagar-produto/:id', 'get', 'App\Controller\ProductsController', 'destroy');
$router->register('/editar-produto/:id', 'get', 'App\Controller\ProductsController', 'edit');
$router->register('/editar-produto/:id', 'post', 'App\Controller\ProductsController', 'update');