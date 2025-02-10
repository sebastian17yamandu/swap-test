<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return string
     * @throws conditon
     **/
    public static function getAbout(): string
    {
        $organization = new Organization;

        $content = View::render('pages/about', [
            'name' => $organization->name,
            'description' => $organization->description
        ]);

        return parent::getPage('Sobre > MVC', $content);
    }
}
