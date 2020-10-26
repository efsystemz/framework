<?php 

use Efsystems\Framework\Application;

if (! function_exists('ui')) {

    /**
     * Render the view 
     *
     * @param  mixed  $view
     * @param  array  $params
     * @return string
     */
    function ui($view, $params = []): string
    {
       return Application::$app->router->renderView($view, $params);
    }

}

if (! function_exists('response')) {

    /**
     * Render the view 
     *
     * @param  mixed  $view
     * @param  array  $params
     * @return string
     */
    function response($view, $params = []): string
    {
       return Application::$app->router->renderView($view, $params);
    }

}

if (! function_exists('request')) {

    /**
     * Render the view 
     *
     * @param  mixed  $view
     * @param  array  $params
     * @return string
     */
    function request($view, $params = []): string
    {
       return Application::$app->router->renderView($view, $params);
    }

}

if (! function_exists('env')) {

    /**
     * Render the view 
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return string
     */
    function env($key, $default = null)
    {
       return $_ENV['$key'];
    }

}