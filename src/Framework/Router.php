<?php

namespace Efsystems\Framework;

use Efsystems\Framework\Exception\NotFoundException;

class Router
{
    private $request;
    private $response;

    private $routeMap = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post(string $url, $callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    public function resolve()
    {
        $method = $this->request->getMethod();

        $url = $this->request->getUrl();

        $callback = $this->routeMap[$method][$url] ?? false;

        if (!$callback) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {

            /**
             * @var $controller \Efsystems\Framework\Controller
             */
            $controller = new $callback[0];

            $controller->action = $callback[1];

            Application::$app->controller = $controller;

            $middlewares = $controller->getMiddlewares();

            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }

            $callback[0] = $controller;

        }

        return call_user_func($callback, $this->request, $this->response);

    }

    public function renderView($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderViewOnly($view, $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }
    
}