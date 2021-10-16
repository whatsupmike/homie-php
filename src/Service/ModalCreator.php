<?php

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\ModalDictionary;
use Symfony\Component\HttpFoundation\Response;

class ModalCreator
{
    public function __construct(private SlackClient\SlackClient $slackClient, private ResponseFactory $responseFactory)
    {
    }

    public function openAddModal(string $triggerId): Response
    {
        $addModalJson = json_encode(ModalDictionary::getAddModal());
        $this->slackClient->viewsOpen($triggerId, $addModalJson);

        return $this->responseFactory->buildEmptyResponse();
    }
}