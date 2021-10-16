<?php

namespace App\Repository;

use App\Entity\HomeOffice;
use App\Entity\SlackUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomeOffice|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeOffice|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeOffice[]    findAll()
 * @method HomeOffice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeOfficeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeOffice::class);
    }

    public function countHomeOfficeInDates(\DateTime $from, \DateTime $till, SlackUser $slackUser): int
    {
        return $this->createQueryBuilder('ho')
            ->select('count(ho.id)')
            ->where('ho.since >= :since')
            ->andWhere('ho.till <= :till')
            ->andWhere('ho.slackUser = :slackUser')
            ->setParameters([
                'since' => $from,
                'till' => $till,
                'slackUser' => $slackUser->getId()
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }
}
