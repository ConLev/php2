<?php

namespace App;

use App\Traits\SingletonTrait;

class App
{
    use SingletonTrait;

    public function run()
    {
        $path = $_REQUEST['path'] ?? '';
        $params = [];

        foreach (explode('/', $path) as $item) {
            if (!$item) {
                continue;
            }
            $params[] = $item;
        }

        $controller = $params[0] ?? 'index';
        $method = $params[1] ?? 'index';
        $controllerName = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

        if (!class_exists($controllerName)) {
            throw new \Exception('Контроллер не найден');
        }

        $controller = new $controllerName;

        if (!method_exists($controller, $method)) {
            throw new \Exception('Метод не найден');
        }

        $controller->$method($_REQUEST);
    }
}