<?php

use App\Controller\Pages;
use App\http\Response;

$router->get('/', [
    function () {
        return new Response(
            200,
            Pages\Home::getHome()
        );
    }
]);

$router->get('/about', [
    function () {
        return new Response(
            200,
            Pages\About::getAbout()
        );
    }
]);


$router->get('/page/{pageID}/{action}', [
    function ($pageID, $action) {
        return new Response(
            200,
            'Page ' . $pageID . ' - ' . $action
        );
    }
]);
