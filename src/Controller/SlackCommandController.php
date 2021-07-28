<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RequestValidator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/command')]
class SlackCommandController  extends AbstractController
{
    public function __construct(private RequestValidator $requestValidator)
    {
    }

    #[Route(path: '', methods: [Request::METHOD_POST])]
    public function command(Request $request): Response
    {
        if($this->requestValidator->validate($request)) {
            return new Response('valid');
        }

        return new Response('test');
    }
}
