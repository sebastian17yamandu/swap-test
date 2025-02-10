<?php

namespace App\http;

class Response
{
    /** 
     * Codi status HTTP
     * @var integer
     */
    private $httpCode = 200;

    /** 
     * Cabeçalho do response
     * @var array
     */
    private $headers = [];

    /** 
     * Tipo do conteudo que sera renderizado
     * @var string
     */
    private $contentType = 'text/hmtl';

    /** 
     * conteudo do response
     * @var mixed
     */
    private $content;

    /** 
     * Construtor
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /** 
     * Alterar o content type do response
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /** 
     * Adcionar um registro no cabeçalho do reponse
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /** 
     * Enviar respostaa para o usuario
     */
    private function sendHeaders()
    {
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /** 
     * Mandar reposta para o usuario
     */
    public function sendReponse()
    {
        $this->sendHeaders();
        
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}
