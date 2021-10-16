<?php

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\CommandDictionary;
use App\Service\RequestValidator\RequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandRequestHandler
{
    public function __construct(
        private RequestValidator $requestValidator,
        private ResponseFactory $responseFactory,
        private ModalCreator $modalCreator
    ) {
    }

    public function handle(Request $request): Response
    {
        if(!$this->requestValidator->validate($request)) {
            return $this->responseFactory->buildFailureResponse();
        }

        return match ($request->request->get('text')) {
            CommandDictionary::EMPTY_COMMAND,
            CommandDictionary::NEW_COMMAND => $this->modalCreator->openAddModal($request->request->get('trigger_id')),
            default => $this->responseFactory->buildHelpResponse()
        };
    }
}
