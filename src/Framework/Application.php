<?php

namespace Efsystems\Framework;

use Efsystems\Framework\DB\Database;

class Application
{
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected $eventListeners = [];

    public static $app;
    public static $ROOT_DIR;
    public $userClass;
    public $layout = 'main';
    public $router;
    public $request;
    public $response;
    public $controller = null;
    public $db;
    public $session;
    public $view;
    public $user;

    public function __construct($rootDir, $config)
    {

        $this->user = null;
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->view = new View();

        $userId = Application::$app->session->get('user');

        if ($userId) {

            $key = $this->userClass::primaryKey();

            $this->user = $this->userClass::findOne([$key => $userId]);

        }

    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function login(UserModel $user)
    {

        $this->user = $user;

        $primaryKey = $user->primaryKey();

        $value = $user->{$primaryKey};

        Application::$app->session->set('user', $value);

        return true;

    }

    public function logout()
    {

        $this->user = null;

        self::$app->session->remove('user');

    }

    public function run()
    {

        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);

        try {

            echo $this->router->resolve();

        } catch (\Exception $e) {

            echo $this->router->renderView('_error', [
                'exception' => $e,
            ]);

        }

    }

    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];

        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }

    }

    public function on($eventName, $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }
    
}