<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'autoload.php';

class Router
{
    private $routes = [];
    private $prefix;
    private $baseRoute;

    public function __construct($prefix = '')
    {
        $this->prefix = trim($prefix, '/');
    }

    public function mount($baseRoute, $function)
    {
        $currentRoute = $this->baseRoute;
        $this->baseRoute .= $baseRoute;
        call_user_func($function);
        $this->baseRoute = $currentRoute;
    }

    public function get($pattern, $function)
    {
        $pattern = trim($this->baseRoute . '/' . $pattern, '/');
        $this->routes[] = ['pattern' => $pattern, 'function' => $function];
    }

    public function route($url)
    {
        // Suppression du préfixe du début de l'URL
        if ($this->prefix && strpos($url, $this->prefix) === 0) {
            $url = substr($url, strlen($this->prefix) + 1);
        }

        // Suppression des barres obliques en trop
        $url = trim($url, '/');

        // Parcourir les routes dans l'ordre
        foreach ($this->routes as $route) {
            $regex = '#^' . preg_replace('/\{(\w+)\}/', '([^/]+)', $route['pattern']) . '$#';

            if (preg_match($regex, $url, $matches)) {
                array_shift($matches);

                list($controllerName, $methodName) = explode('@', $route['function']);
                $controller = new $controllerName();
                $controller->$methodName(...$matches);
                return;
            }
        }

        http_response_code(404);
        require 'views/error404.php';
    }
}

// Instanciation du routeur
$router = new Router('DemoMVCAlpha');

// Ajout des routes
$router->get('', 'HomeController@index'); // Racine
$router->get('about', 'HomeController@about'); // A propos

// montage tasks
$router->mount('/tasks', function () use ($router) {
    $router->get('', 'TaskController@index');
    $router->get('{id}', 'TaskController@show');
});

// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
