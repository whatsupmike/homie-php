<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CommandRequestHandler;
use App\Service\InteractionRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class ApiController  extends AbstractController
{
    public function __construct(
        private CommandRequestHandler $commandRequestHandler,
        private InteractionRequestHandler $interactionRequestHandler
    ) {
    }

    #[Route(path: '/command', methods: [Request::METHOD_POST])]
    public function command(Request $request): Response
    {
        return $this->commandRequestHandler->handle($request);

    }

    #[Route(path: '/interaction', methods: [Request::METHOD_POST])]
    public function interaction(Request $request): Response
    {
        return $this->interactionRequestHandler->handle($request);
    }
}
