<?php

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\InteractionDictionary;
use App\Dictionary\ModalDictionary;
use App\Exception\AlreadyExistsException;
use App\Exception\InvalidDateException;
use App\Service\HomeOffice\HomeOfficeAdder;
use App\Service\HomeOffice\HomeOfficeFactory;
use App\Service\RequestValidator\RequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InteractionRequestHandler
{
    public function __construct(
        private RequestValidator $requestValidator,
        private ResponseFactory $responseFactory,
        private HomeOfficeFactory $homeOfficeFactory,
        private HomeOfficeAdder $homeOfficeAdder,
        private PayloadFactory $payloadFactory
    ) {
    }

    public function handle(Request $request): Response
    {
        if(!$this->requestValidator->validate($request)) {
            return $this->responseFactory->buildFailureResponse();
        }

        $payload = $this->payloadFactory->buildFromRequest($request);
        $homeOffice = $this->homeOfficeFactory->buildFromPayload($payload);

        try {
            match ($payload->getPayload()['view']['callback_id']) {
                InteractionDictionary::ADD_CALLBACK => $this->homeOfficeAdder->add($homeOffice)
            };
        } catch (InvalidDateException $invalidDateException) {
            return $this->responseFactory->buildFormErrorResponse(ModalDictionary::TILL_BLOCK_ID, 'Invalid date');
        } catch (AlreadyExistsException $alreadyExistsException) {
            return $this->responseFactory->buildFormErrorResponse(ModalDictionary::TILL_BLOCK_ID, 'Already exists');
        }

        return $this->responseFactory->buildEmptyResponse();
    }
}