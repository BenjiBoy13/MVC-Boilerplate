<?php


namespace App\Controllers;

use App\Libraries\BaseController;

class HomeController extends BaseController
{
    public function index(): void
    {
        $data = [
            'title' => 'Hello Twig'
        ];

        $this->renderView('index.html.twig', $data);
        return;
    }
}