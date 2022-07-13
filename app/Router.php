<?php

namespace App\App;

use Exception;

class Router
{
    /**
     * @var array|array[]
     */
    protected array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * @var int
     */
    public static int $page = 1;

    /**
     * @param string $file
     * @return static
     */
    public static function load(string $file)
    {
        $router = new static();
        require $file;

        return $router;
    }

    /**
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function checkPage(string $uri): string
    {
        if (intval($uri)) {
            self::$page = $uri;
            return '';
        }
        $array = explode('/', $uri);
        $page = intval(end($array));
        array_pop($array);
        if ($page) {
            self::$page = $page;
            return implode('/', $array);
        }
        self::$page = 1;
        return $uri;
    }

    /**
     * @param $uri
     * @param $controller
     * @return void
     */
    public function post($uri, $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * @param string $uri
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    public function direct(string $uri, string $method)
    {

        $uri = $this->checkPage($uri);

        if (array_key_exists($uri, $this->routes[$method])) {
            return $this->callAction(...explode('@', $this->routes[$method][$uri]));
        } else {
            return $this->callAction('PageController', 'page_404');
        }

    }

    /**
     * @param string $controller
     * @param string $action
     * @return mixed
     * @throws Exception
     */
    protected function callAction(string $controller, string $action)
    {
        $controller =  "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} does not have {$action}");
        }

        return $controller->$action();
    }
}
