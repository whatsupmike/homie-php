<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Payload;
use App\Entity\SlackUser;
use Symfony\Component\HttpFoundation\Request;

class PayloadFactory
{
    private const PAYLOAD_KEY = 'payload';

    private const PAYLOAD_VIEW_KEY = 'view';
    private const PAYLOAD_STATE_KEY = 'state';
    private const PAYLOAD_VALUES_KEY = 'values';

    private const USER_OBJECT_KEY = 'user';

    public function __construct(private SlackUserFactory $slackUserFactory)
    {
    }

    public function buildFromRequest(Request $request): Payload
    {
        $payload = json_decode($request->request->get(self::PAYLOAD_KEY), true);
        $user = $this->slackUserFactory->findOrCreateFromPayload($payload[self::USER_OBJECT_KEY]);
        $values = $payload[self::PAYLOAD_VIEW_KEY][self::PAYLOAD_STATE_KEY][self::PAYLOAD_VALUES_KEY];

        return $this->build($payload, $user, $values);
    }

    private function build(array $payload, SlackUser $user, array $values): Payload
    {
        return (new Payload())->setPayload($payload)->setUser($user)->setValues($values);
    }
}