<?php


namespace App\Controllers;

use App\Libraries\BaseController;
use App\Services\SessionService;


class DocsController extends BaseController
{
    public function index(): void
    {
        $this->renderView('docs/index.html.twig');
    }

    public function about(SessionService $sessionManager, array $params)
    {
        $sessionManager->setSession("name", 'Benjamin Gil');

        $data = [
            'name' => $sessionManager->getSession('name')
        ];


        $this->renderView('docs/about.html.twig', $data);
    }
}