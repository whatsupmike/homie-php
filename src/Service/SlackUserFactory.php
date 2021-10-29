<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\SlackUser;
use App\Repository\SlackUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SlackUserFactory
{
    private const PAYLOAD_USER_ID_KEY = 'id';
    private const PAYLOAD_USERNAME_KEY = 'username';

    private const REQUEST_USER_ID_KEY = 'user_id';
    private const REQUEST_USERNAME_KEY = 'user_name';

    public function __construct(private SlackUserRepository $slackUserRepository, private EntityManagerInterface $entityManager)
    {
    }

    public function findOrCreateFromPayload(array $payloadUser): SlackUser
    {
        return $this->findOrCreate(
            $payloadUser[self::PAYLOAD_USER_ID_KEY],
            $payloadUser[self::PAYLOAD_USERNAME_KEY]
        );
    }

    public function findOrCreateFromRequest(Request $request): SlackUser
    {
        return $this->findOrCreate(
            $request->request->get(self::REQUEST_USER_ID_KEY),
            $request->request->get(self::REQUEST_USERNAME_KEY)
        );
    }

    public function findOrCreate(string $userId, string $username): SlackUser
    {
        $slackUser = $this->slackUserRepository->findByUserId($userId);

        if (!$slackUser) {
            $slackUser = $this->build($userId, $username);

            $this->entityManager->persist($slackUser);
            $this->entityManager->flush();
        }

        return $slackUser;
    }

    private function build(string $userId, string $username): SlackUser
    {
        return (new SlackUser())->setUserId($userId)->setUsername($username);
    }
}