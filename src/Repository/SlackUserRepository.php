<?php

namespace App\Repository;

use App\Entity\SlackUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackUser[]    findAll()
 * @method SlackUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackUser::class);
    }

    public function findByUserId(string $userId): ?SlackUser
    {
        return $this->findOneBy(['userId' => $userId]);
    }
}
