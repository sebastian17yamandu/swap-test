<?php

namespace App\Utils;

class View
{

    private static $vars = [];

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param array $vars
     * @return void
     * @throws conditon
     **/
    public static function init($vars = []): void
    {
        self::$vars = $vars;
    }

    /** 
     * Método responsável por retornar conteúdo de VIEW
     * @param string $view
     * @return string
     */
    private static function getContentView($view): string
    {
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /** 
     * Método responsável por renderizar VIEW
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = []): string
    {
        $contentView = self::getContentView($view);

        $vars = array_merge(self::$vars, $vars);

        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, array_values($vars), $contentView);
    }
}
