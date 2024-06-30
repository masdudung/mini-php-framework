<?php

namespace System\Core;

use System\Core\View;

class Controller
{
    public function loadModel($model)
    {
        require_once '../app/Models/' . $model . '.php';
        return new $model();
    }

    public function render($view, $data = [])
    {
        $blade = new View();
        echo $blade->render($view, $data);
    }
}
