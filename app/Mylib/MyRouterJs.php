<?php

namespace App\Mylib;

class MyRouterJs
{
    static function routerJson(array $routers)
    {
        $data = [];

        foreach ($routers as $router) {
            $data[$router] = route($router);
        }

        return json_encode($data);
    }
}
