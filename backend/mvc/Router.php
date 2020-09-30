<?php

namespace Mvc;

class Router
{
    protected $routes = [];
    protected $params = [];
    protected $controllerName;
    protected $controllerClassName;
    protected $controllerAction;
    protected $controllerObject;
    protected $parsedUrl;

    public function add($route, $params = [])
    {
        $route = '/^' . preg_replace('/\//', '\\/', $route) . '$/i';
        $this->routes[$route] = $params;
    }

    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                    $this->params = $params;
                    return true;
                }
            }
        }

        return false;
    }

    protected function parseUrl($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    public function dispatch()
    {
        $this->parsedUrl = $this->parseUrl(strtok($_SERVER["REQUEST_URI"], '?'));

        if (!$this->match($this->parsedUrl)) {
            die('No route matched.');
        }

        $this->controllerName = $this->params['controller'];
        $this->controllerClassName = "App\Controllers\\$this->controllerName";

        if (!class_exists($this->controllerClassName)) {
            die("Controller class '$this->controllerClassName' not found");
        }

        $this->controllerObject = new $this->controllerClassName(array_merge($_SERVER, $_REQUEST));
        $this->controllerAction = $this->params['action'];

        if (!method_exists($this->controllerObject, $this->controllerAction)) {
            die("Action '$this->controllerAction' in controller '$this->controllerName' is not found");
        }

        $this->controllerObject->{$this->controllerAction}();
    }
}
