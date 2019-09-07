<?php


namespace App\Controllers;

use App\Libraries\BaseController;
use App\Libraries\ControllerInterface;
use App\Services\SessionManager;


class DocsController extends BaseController implements ControllerInterface
{
    public function index(): void
    {
        $this->renderView('docs/index.html.twig');
    }

    public function about(SessionManager $sessionManager, array $params)
    {
        $sessionManager->setSession("name", 'Benjamin Gil');

        $data = [
            'name' => $sessionManager->getSession('name')
        ];


        $this->renderView('docs/about.html.twig', $data);
    }
}