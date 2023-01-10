# mvc-propose-01

I think we have to make things easier for other people.
So I have this personal goal, in my subconscious, to build a easy to use MVC.

## First I did Router

Router register what you whant to get from the URL and where it should go.

Registration:
```php
$router = new Router();

$router->register('/products',     'get', 'ProductsController', 'index');
$router->register('/products/new', 'get', 'ProductsController', 'new');
```

It's not my favorite way yet, but it is as near as I can get with the time I have.

## Second I did AutoLoader

I like the `spl_autoload_register`.
You can basically call a `new Class` and it requires the file for you, you don't need thousands of requires now.


# Proposta de MVC #01

Julio *oi*


# asdasd
## asdasd
### asdasdasd