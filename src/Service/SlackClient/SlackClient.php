<?php

declare(strict_types=1);

namespace App\Service\SlackClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SlackClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $slackApiUrl,
        private string $slackBotToken
    ) {
    }

    public function chatPostMessage(string $channel, array $arguments = []): ResponseInterface
    {
        $method = 'chat.postMessage';
        $payload = [
            'channel' => $channel,
        ] + $arguments;

        return $this->connect($method, $payload);
    }

    public function viewsOpen(string $triggerId, string $view): ResponseInterface
    {
        $method = 'views.open';
        $payload = [
                'trigger_id' => $triggerId,
                'view' => $view,
            ];

        return $this->connect($method, $payload);
    }

    public function usersProfileGet(string $user, array $arguments = []): ResponseInterface
    {
        $method = 'users.profile.get';
        $payload = [
            'user' => $user,
        ] + $arguments;

        return $this->connect($method, $payload);
    }

    private function connect(string $method, array $payload): ResponseInterface
    {
        $url = sprintf('%s/%s', $this->slackApiUrl, $method);

        return $this->httpClient->request('POST', $url, [
            'auth_bearer' => $this->slackBotToken,
            'body' => $payload
        ]);
    }
}
