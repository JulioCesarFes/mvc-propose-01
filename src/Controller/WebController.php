<?php

namespace App\Controller;

use Core\View\Views;

class WebController
{

    function index()
    {
        Views::render('web.index', get_defined_vars());
    }
}