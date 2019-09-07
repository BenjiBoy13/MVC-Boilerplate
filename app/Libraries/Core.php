<?php

namespace App\Libraries;

use App\Services\SessionManager;

class Core {
    protected $currentController = "App\\Controllers\\HomeController";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

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

    public function getUrl()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}