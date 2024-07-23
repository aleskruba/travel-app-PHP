<?php

namespace Core;


use Core\Middleware\Guest;
use Core\Middleware\Auth;

$baseUri = '/travel/';
$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

//$routes = require('routes.php');


/* if ($uri === $baseUri) {
    require 'controllers/index.php';
} else if ($uri === $baseUri.'traveltips'){
    require 'controllers/traveltips.php';
}else if ($uri === $baseUri.'spolucesty'){
    require 'controllers/spolucesty.php';
}else if ($uri === $baseUri.'signup'){
    require 'controllers/signup.php';
}else if ($uri === $baseUri.'login'){
    require 'controllers/login.php';
} */


/* $routes = [
    $baseUri.''=> 'controllers/index.php',
    $baseUri.'traveltips' => 'controllers/traveltips.php',
    $baseUri.'traveltips/:country' => 'controllers/traveltips.php',
    $baseUri.'traveltips/:country/message' => 'controllers/traveltipsMessage.php',
    $baseUri.'spolucesty' => 'controllers/spolucesty.php',
    $baseUri.'signup' => 'controllers/signup.php',
    $baseUri.'login' => 'controllers/login.php'
];
 */


/* function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        abort();
    }

} */

/* function routeToController($uri, $routes) {
    foreach ($routes as $route => $controller) {
        $routePattern = preg_replace('/:[^\/]+/', '([^\/]+)', $route);
        if (preg_match("#^$routePattern$#", $uri, $matches)) {
            array_shift($matches); // Remove the full match from the array
            foreach ($matches as $key => $value) {
                $_GET['param' . ($key + 1)] = $value;
            }
            require $controller;
            return;
        }
    }
    abort();
}

function abort($code = 404) {
    http_response_code($code);
    require "views/partials/$code.php";
    die();
}

routeToController($uri, $routes);
 */



 class Router {
    protected $routes = [];


    public function add($method,$uri,$controller){

        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware'=>null
        ];

        return $this;
    }

    public function get($uri, $controller) {
       return $this->add("GET",$uri,$controller);
    }

    public function post($uri, $controller) {
       return $this->add("POST",$uri,$controller);
    }

    public function put($uri, $controller) {
      return  $this->add("PUT",$uri,$controller);
    }

    public function patch($uri, $controller) {
       return $this->add("PATCH",$uri,$controller);
    }

    public function delete($uri, $controller) {
       return $this->add("DELETE",$uri,$controller);
    }


    public function only($key) {
        $lastKey = array_key_last($this->routes);
        if ($lastKey !== null) {
            $this->routes[$lastKey]['middleware'] = $key;
        } else {
            // Handle the case where no routes are defined yet
            throw new \Exception("No routes to apply middleware to.");
        }
        return $this;
    }


    public function route($uri, $method) {
        // Decode the URI to handle encoded characters
        $uri = urldecode($uri);
   
        foreach ($this->routes as $route) {
            // Convert route URI with :parameters to regex
            $routePattern = preg_replace('/:[^\/]+/', '([^\/]+)', $route['uri']);

            // Check if the current route matches the requested URI and method
            if (preg_match("#^$routePattern$#", $uri, $matches) && $route['method'] === strtoupper($method)) {
                array_shift($matches); // Remove the full match from the array
       
                // Extract parameters and populate $_GET array with 'param' prefix
                preg_match_all('/:([^\/]+)/', $route['uri'], $paramNames);
                foreach ($matches as $index => $match) {
                    $_GET['param' . ($index + 1)] = $match;
                }

                // Handle middleware
                if ($route['middleware']) {
                    $middlewareClass = 'Core\\Middleware\\' . ucfirst($route['middleware']);
                    if (class_exists($middlewareClass)) {
                        (new $middlewareClass)->handle();
                    } else {
                        throw new \Exception("Middleware class $middlewareClass does not exist.");
                    }
                }

                // Require the controller file
                return require $route['controller'];
            }
        }

        $this->abort();
    }

    protected function abort($code = 404) {
        http_response_code($code);
        require "views/partials/$code.php";
        die();
    }
}