<?php

namespace Core\View;
class Views
{
    protected static string $views_path = '';

    public static function setPath(string $path): void
    {
        self::$views_path = rtrim($path, '/') . '/';
    }

    static function render($filepath, $arguments)
    {

        extract($arguments);
        require_once self::$views_path . $filepath . '.html.php';

    }

    static function redirect($path)
    {
        header("Location: $path");
    }

}