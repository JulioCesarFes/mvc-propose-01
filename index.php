<?php

spl_autoload_register(function ($className) { require_once '$className.php'; });

$router = new Router();

$router->register('/products', 			 'get', 	 'ProductsController', 'index');
$router->register('/products/new', 	 'get', 	 'ProductsController', 'new');
$router->register('/products/edit',  'get', 	 'ProductsController', 'edit');
$router->register('/products', 			 'post',   'ProductsController', 'create');

$router->register('/products/:slug', 'get',    'ProductsController', 'show');
$router->register('/products/:slug', 'patch',  'ProductsController', 'update');
$router->register('/products/:slug', 'delete', 'ProductsController', 'destroy');
