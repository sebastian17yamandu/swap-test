<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Home extends Page
{
    /**
     * Método responsavel por retornar conteudo da View Home
     * @return string
     */
    public static function getHome()
    {
        $organization = new Organization();
        $content = View::render('pages/home', [
            'name' => $organization->name
        ]);

        return parent::getPage('Blog MVC', $content);
    }
}
