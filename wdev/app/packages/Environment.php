<?php

namespace App\packages;

class Environment
{
    public static function load($dir)
    {
        if (!file_exists($dir . '/.env')) {
            echo '.env não encontrado';
            return false;
        }

        $lines = file($dir . '/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }
    }
}
