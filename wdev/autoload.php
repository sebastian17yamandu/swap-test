<?php

spl_autoload_register(
    function (string $class) {
        $path = str_replace('Seba\\Althomedev\\', 'App', $class);
        $dir_file = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $dir_file .= '.php';

        if (file_exists($dir_file)) :
            require_once $dir_file;
        endif;
    }
);