<?php

namespace App\Libraries;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseController
{
    //Load model
    public function loadModel($model)
    {
        if (\class_exists('App\\Models\\' . $model)) {
            $model = 'App\\Models\\' . $model;
        }

        //Instantiate model
        return new $model();
    }

    //Load view
    public function renderView($view, $data = [])
    {
        $twigLoader = new FilesystemLoader('views');
        $twig = new Environment($twigLoader);

        echo $data ? $twig->render($view, $data) : $twig->render($view);
    }
}