<?php

declare(strict_types=1);

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    public function __construct(private string $commandName)
    {
    }

    public function buildHelpResponse(): Response
    {
        $message = [
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Need help? I\'m there for You! :house_with_garden:',
                        'emoji' => true
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Homie is simple :slack: app for requesting Home Office.',
                        'emoji' => true
                    ]
                ],
                [
                    'type' => 'header',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => ':book: Available commands:',
                        'emoji' => true
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%1$s` *or* `%1$s new`: %2$sModal would pop up where You would be able to select dates and send home office request to Your supervisor', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s today`: %sShortcut to request HO for today', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s tomorrow`: %sShortcut to request HO for tomorrow', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s delete`: %sDelete lasting or upcomming HO', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s list`: %sList all HO requests 3 weeks back', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s list today`:%sList all HO requests for today', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => sprintf('`%s help`:%sHelp! Duhhhh!', $this->commandName, PHP_EOL)
                    ]
                ],
                [
                    'type' => 'divider'
                ],
                [
                    'type' => 'context',
                    'elements' => [
                        [
                            'type' => 'mrkdwn',
                            'text' => "Still needs some help?\nTry here https://github.com/whatsupmike/homie-php also feel free to contribute!"
                        ]
                    ]
                ]
            ]
        ];

        return new JsonResponse($message);
    }

    public function buildSuccessResponse(): Response
    {
        return new JsonResponse($this->buildSuccessMessage());
    }

    public function buildFailureResponse(): Response
    {
        return new JsonResponse($this->buildFailureMessage());
    }

    public function buildFormErrorResponse(string $field, string $message): Response
    {
        return new JsonResponse([
            'response_action' => 'errors',
            'errors' => [
                $field => $message
            ]
        ]);
    }

    public function buildEmptyResponse(): Response
    {
        return new Response();
    }

    public function buildSuccessMessage(): array
    {
        return $this->buildSimpleMessage(':white_check_mark: Success');
    }

    public function buildFailureMessage(): array
    {
        return $this->buildSimpleMessage('Failure');
    }

    #[ArrayShape(
        [
            'blocks' => "false|string"
        ]
    )]
    private function buildSimpleMessage(string $message): array
    {
        return [
            'blocks' => json_encode([
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => $message
                    ]
                ]
            ])
        ];
    }
}