<?php

spl_autoload_register(function ($className) { require_once "$className.php"; });

$router = new Router();

$router->register('/products', 'get', 'ProductsController', 'index');