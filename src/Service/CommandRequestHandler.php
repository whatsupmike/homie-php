<?php

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\CommandDictionary;
use App\Exception\AlreadyExistsException;
use App\Exception\InvalidDateException;
use App\Service\HomeOffice\HomeOfficeAdder;
use App\Service\HomeOffice\HomeOfficeFactory;
use App\Service\RequestValidator\RequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandRequestHandler
{
    public function __construct(
        private RequestValidator $requestValidator,
        private ResponseFactory $responseFactory,
        private ModalCreator $modalCreator,
        private SlackUserFactory $slackUserFactory,
        private HomeOfficeFactory $homeOfficeFactory,
        private HomeOfficeAdder $homeOfficeAdder
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
            CommandDictionary::TODAY_COMMAND => $this->createForDate($request, new \DateTime()),
            CommandDictionary::TOMORROW_COMMAND => $this->createForDate($request, new \DateTime('+1 day')),
            default => $this->responseFactory->buildHelpResponse()
        };
    }

    private function createForDate(Request $request, \DateTime $date): Response
    {
        $user = $this->slackUserFactory->findOrCreateFromRequest($request);

        $homeOffice = $this->homeOfficeFactory->build($date, $date, $user);

        try {
            $this->homeOfficeAdder->add($homeOffice);
        } catch (InvalidDateException $invalidDateException) {
            return $this->responseFactory->buildFailureResponse('Invalid date');
        } catch (AlreadyExistsException $alreadyExistsException) {
            return $this->responseFactory->buildFailureResponse('Already exists');
        }

        return $this->responseFactory->buildEmptyResponse();
    }
}
