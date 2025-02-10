<?php

namespace App\http;

use Closure;
use Exception;
use ReflectionFunction;

// echo '<pre>';
// print_r($parseUrl);
// echo '</pre>';
// exit;

class Router
{
    private $url;
    private $prefix = '';
    private $routes = [];

    /** Instance de Request @var Request */
    private $resquest;

    public function __construct($url)
    {
        $this->resquest = new Request;
        $this->url = $url;
        $this->setPrefix();
    }

    public function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = [])
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];
        $patternVariables = '/{(.*?)}/';
        if (preg_match_all($patternVariables, $route, $matches)) {
            $route = preg_replace($patternVariables, '(.*?)', $route);
            $params['variables'] = $matches[1];
            /*echo '<pre>';
            print_r($matches);
            echo '</pre>';
            exit;*/
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        /*cho '<pre>';
        print_r($patternRoute);
        echo '</pre>';*/

        $this->routes[$patternRoute][$method] = $params;
    }

    /** 
     * Definir metodo de rota GET 
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /** 
     * Definir metodo de rota POST 
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /** 
     * Definir metodo de rota PUT 
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /** 
     * Definir metodo de rota DELETE 
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri()
    {
        $uri = $this->resquest->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }

    private function getRoute()
    {
        $uri = $this->getUri();

        $httpMethod = $this->resquest->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri, $matches)) {
                if (isset($methods[$httpMethod])) {
                    unset($matches[0]);

                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->resquest;


                    /*echo '<pre>';
                    print_r($matches);
                    echo '</pre>';
                    exit;*/

                    return $methods[$httpMethod];
                }

                throw new Exception('Metodo não permitido', 405);
            }
        }

        throw new Exception('pageNotFound', 404);
    }

    /** 
     * Executa rota aual
     * @return Response
     */
    public function run()
    {
        try {
            $route = $this->getRoute();
            /*echo '<pre>';
            print_r($route);
            echo '</pre>';
            exit;*/


            if (!isset($route['controller'])) {
                throw new Exception('Pedido não pode ser processado', 500);
            }

            $args = [];
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            /*echo '<pre>';
            print_r($args);
            echo '</pre>';
            exit;*/

            return call_user_func_array($route['controller'], $args);

            // throw new Exception(
            //     'pageNotFound',
            //     404
            // );
        } catch (Exception $e) {
            return new Response(
                $e->getCode(),
                $e->getMessage()
            );
        }
    }
}
