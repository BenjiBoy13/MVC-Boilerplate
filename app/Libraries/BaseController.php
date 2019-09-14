<?php

namespace App\Libraries;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * -------------------------------------------------------------------
 * BaseController Class
 * -------------------------------------------------------------------
 *
 * The base controller specifies helper methods to their children
 * so they can render a twig view or load a database model
 *
 * @autor Benjamin Gil FLores
 * @version 1.0.0
 */
class BaseController
{
    /**
     * Loads the model needed
     *
     * @param $model;
     * @return Object
     */
    public function loadModel($model)
    {
        if (\class_exists('App\\Models\\' . $model)) {
            $model = 'App\\Models\\' . $model;
        }

        //Instantiate model
        return new $model();
    }

    /**
     * Renders the twig view with extra data if needed
     *
     * @param $view
     * @param $data
     * @throws \Exception if twig cant find the view
     * @return void
     */
    public function renderView($view, $data = [])
    {
        $twigLoader = new FilesystemLoader('views');
        $twig = new Environment($twigLoader);
        $twig->addGlobal('site', SITENAME);

        try {
            echo $data ? $twig->render($view, $data) : $twig->render($view);
        } catch (\Exception $e) {
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre>';
        }
    }
}