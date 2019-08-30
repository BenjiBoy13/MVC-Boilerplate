<?php

namespace App\Libraries;

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

        // Call a callback with arrays of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

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