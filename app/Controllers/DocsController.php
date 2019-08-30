<?php


namespace App\Controllers;

use App\Libraries\BaseController;


class DocsController extends BaseController
{
    public function index()
    {
        $this->renderView('docs/index.html.twig');
    }

    public function about()
    {
        $this->renderView('docs/about.html.twig');
    }
}