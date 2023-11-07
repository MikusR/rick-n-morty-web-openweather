<?php

namespace App;

use App\Controllers\EpisodeController;
use App\Models\EpisodeDb;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Symfony\Bridge\Twig\Extension\DumpExtension;
use FastRoute;

class Application
{
    static EpisodeDb $episodeDb;

    public function run()
    {
        EpisodeDb::init();

        $loader = new FilesystemLoader(__DIR__ . '/../app/Views');
        $twig = new Environment($loader, ['debug' => true]);
        $twig->addExtension(new DebugExtension());

        {
            $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
                $router->addRoute('GET', '/', ['App\Controllers\EpisodeController', 'index']);
                $router->addRoute('GET', '/episode/search/{episode}', ['App\Controllers\EpisodeController', 'search']);
                $router->addRoute('GET', '/episode/search', ['App\Controllers\EpisodeController', 'search']);
                $router->addRoute('GET', '/episode/{id}', ['App\Controllers\EpisodeController', 'show']);
            });

// Fetch method and URI from somewhere
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }
            $uri = rawurldecode($uri);

            $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
            switch ($routeInfo[0]) {
                case FastRoute\Dispatcher::NOT_FOUND:
                    // ... 404 Not Found
                    break;
                case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    // ... 405 Method Not Allowed
                    break;
                case FastRoute\Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    [$className, $method] = $handler;

//
                    /**
                     * @var Response $response
                     */
                    $response = (new $className())->{$method}($vars);
//
                    $view = $response->getViewName();
                    $data = $response->getData();
                    echo $twig->render("$view.twig", $data);

                    break;
            }
        }
    }

    public function __construct()
    {
    }
}