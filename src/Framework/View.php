<?php

namespace Efsystems\Framework;

class View
{
    
    public $title = '';

    public function renderView($view, array $params)
    {

        $layoutName = Application::$app->layout;

        if (Application::$app->controller) {

            $layoutName = Application::$app->controller->layout;

        }

        $viewContent = $this->renderViewOnly($view, $params);

        ob_start();

        include_once Application::$ROOT_DIR."/application/views/layouts/$layoutName.php";

        $layoutContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    public function renderViewOnly($view, array $params)
    {

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once Application::$ROOT_DIR."/application/views/$view.php";

        return ob_get_clean();

    }

}