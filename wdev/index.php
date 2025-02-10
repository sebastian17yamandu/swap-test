<?php

require __DIR__ . '/autoload.php';

use App\http\Router;
use App\packages\Environment;
use App\Utils\View;

Environment::load(__DIR__);
print_r(getenv('DB_HOST'));


define('URL', 'http://localhost/__site/wdev');

View::init([
    'URL' => URL
]);

$router = new Router(URL);
include __DIR__ . '/routes/pages.php';
$router->run()->sendReponse();
