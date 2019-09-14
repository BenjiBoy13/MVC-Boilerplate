<?php


namespace App\Controllers;

use App\Libraries\BaseController;

class NoController extends BaseController
{
    public function index() {
        \http_response_code(404);
        $this->renderView('server/404.html.twig');
    }
}