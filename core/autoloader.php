<?php

$autoloader = [
    'App\\' => 'src/',
    'Core\\' => 'core/'
];

spl_autoload_register(function ($class) use ($autoloader) {
    foreach ($autoloader as $prefix => $base_dir)
    {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Pega o nome relativo da classe
        $relative_class = substr($class, $len);

        // Substitui o prefixo do namespace pelo diretório base, substitui os separadores
        // de namespace por separadores de diretório no nome da classe relativa e adiciona '.php'
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        $file = __DIR__ . '/../' . $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file))
        {
            require $file;
            return;
        }
    }
});