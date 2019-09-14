<?php

namespace App\Libraries;

use App\Controllers\HomeController;
use App\Controllers\NoController;

/**
 * -------------------------------------------------------------------
 * Core Class
 * -------------------------------------------------------------------
 *
 * This class implements the methods that handles the url requested by
 * the user and serves up the controller needed for that url and
 * initialize the required controller method with the required parameters
 *
 * @autor Benjamin Gil FLores
 * @version 1.0.0
 */
class Core {
    protected $currentController = "App\\Controllers\\NoController";
    protected $currentMethod = "index";
    protected $params = [];

    /**
     * The class constructor calls the getUrl method to retrieve the url
     * asked by the client and serves the required controller and method
     */
    public function __construct()
    {
        $url = $this->getUrl();

        // If the url is null we have no parameters or pages, we render home
        if ($url == []) {
            $home = new HomeController();
            $home->index();
            return;
        }

        //Look in Controllers for first index or value
        if (\class_exists('App\\Controllers\\' . ucwords($url[0]) . 'Controller'))
        {
            //If exists, set as controller
            $this->currentController = 'App\\Controllers\\' . ucwords($url[0]) . 'Controller';

            // Unset 0 index
            unset($url[0]);
        }

        //Instantiate it
        $this->currentController = new $this->currentController;

        //Check for second part of url
        if (isset($url[1]))
        {
            //Check if the method exists in controller
            if (method_exists($this->currentController, $url[1]))
            {
                $this->currentMethod = $url[1];

                unset($url[1]);
            } else {
                // If the method does not exist return a 404 page
                $noController = new NoController();
                $noController->index();
                return;
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        $reflection = new \ReflectionMethod($this->currentController, $this->currentMethod);
        $requiredMethods = $reflection->getParameters();
        $parametersToBePassed = array();

        foreach ($requiredMethods as $requiredMethod) {
            if ($requiredMethod->getClass()) {
                $service = $requiredMethod->getClass()->name;
                $service = new $service;
                array_push($parametersToBePassed, $service);
            } else {
                array_push($parametersToBePassed, $this->params);
            }
        }

        $method = $this->currentMethod;

        \call_user_func_array(array($this->currentController, $method), $parametersToBePassed);

    }

    /**
     * This method retrieves the url asked by client
     *
     * @return array
     */
    public function getUrl(): array
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }

        return array();
    }

}