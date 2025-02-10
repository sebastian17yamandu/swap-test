<?php

namespace App\http;

class Request
{
    /** 
     * Método HTTP da requisção
     * @var string
     */
    private $httpMethod;

    /** 
     * URI da pagina
     * @var string
     */
    private $uri;

    /** 
     * Parametro da URL ($_GET)
     * @var string
     */
    private $queryparams;

    /** 
     * Variáveis recebidas no POST da pagina ($_POST)
     * @var array
     */
    private $postVars = [];

    /** 
     * Cabeçalho da requisição
     * @var array
     */
    private $headers = [];

    /** 
     * Construtor da classe
     */
    public function __construct()
    {
        $this->queryparams = $_GET;
        $this->postVars = $_POST;
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /** 
     * Retornar metodo HTTP da requisição
     * @var string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /** 
     * Retornar parametros 
     */
    public function getUri()
    {
        return $this->uri;
    }

    public function getParams()
    {
        return $this->queryparams;
    }

    public function getPostvars()
    {
        return $this->postVars;
    }

    public function getHeader()
    {
        return $this->headers;
    }

    
}
