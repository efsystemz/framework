<?php

namespace Efsystems\Framework;

use Efsystems\Framework\Middlewares\BaseMiddleware;

class Controller
{

    public $layout = 'main';

    public $action = '';

    /**
     * @var \Efsystems\Framework\Middlewares\BaseMiddleware[]
     */
    protected $middlewares = [];

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \Efsystems\Framework\Middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
    
}