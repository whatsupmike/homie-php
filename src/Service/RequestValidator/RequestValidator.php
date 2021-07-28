<?php

declare(strict_types=1);

namespace App\Service\RequestValidator;

use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    private const VALID_TIMESTAMP_MODIFIER = '-1min';
    private const TIMEZONE = 'Europe/Warsaw';

    public function __construct(private string $signingSecret)
    {
    }

    public function validate(Request $request): bool
    {
        $requestBody = $request->getContent();
        $timestamp = $request->headers->get('X-Slack-Request-Timestamp');
        $slackSignature = $request->headers->get('X-Slack-Signature');

        if (!$this->validateTimestamp($timestamp)) {
            return false;
        }

        $signingString = sprintf('v0:%s:%s', $timestamp, $requestBody);
        $signature = sprintf('v0=%s', hash_hmac('sha256', $signingString, $this->signingSecret));

        return hash_equals($signature, $slackSignature);
    }

    private function validateTimestamp(string $timestamp): bool
    {
        $timezone = new \DateTimeZone(self::TIMEZONE);
        $serverDate = (new \DateTime())->setTimezone($timezone);
        $slackDate = (new \DateTime('@'.$timestamp))->setTimezone($timezone);

        return $slackDate > $serverDate->modify(self::VALID_TIMESTAMP_MODIFIER);
    }
}