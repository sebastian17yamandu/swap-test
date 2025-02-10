<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    /**
     * Método responsável por renderizar topo da pagina
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /** 
     * Método reponsável por renderizar footer da pagina
     * @return string
     * 
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsavel por retornar conteudo da pagina generica
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }
}
