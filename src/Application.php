<?php

namespace App;

use App\Exception\ApplicationException;
use App\View\Renderable;
use App\View\View;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Application
 * @package App
 */
class Application
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    public function run(string $url, string $method)
    {
        try {
            $result = $this->router->dispatch($url, $method);
            if ($result instanceof Renderable) {
                $result->render();
            } else {
                echo $result;
            }
        } catch (ApplicationException $e) {
            $this->renderException($e);
        }
    }

    private function renderException(ApplicationException $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } else {
            http_response_code(404);
            $view = new View(
                'errors\error',
                ['error' => 'Ошибка 404. Страница не найдена', 'title' => 'произошла ошибка']
            );
            $view->render();
        }
    }

    private function initialize()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => Config::getInstance()->get('db.host'),
            'database' => Config::getInstance()->get('db.dbname'),
            'username' => Config::getInstance()->get('db.user'),
            'password' => Config::getInstance()->get('db.password'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

    }
}
