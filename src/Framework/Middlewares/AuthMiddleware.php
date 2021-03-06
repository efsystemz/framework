<?php

namespace Efsystems\Framework\Middlewares;


use Efsystems\Framework\Application;
use Efsystems\Framework\Exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{

    protected $actions = [];

    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {

        if (Application::isGuest()) {

            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {

                throw new ForbiddenException();
                
            }

        }

    }

}