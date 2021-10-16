<?php

declare(strict_types=1);

namespace App\Service\HomeOffice;

use App\Entity\HomeOffice;
use App\Event\HomeOfficeAddedEvent;
use App\Exception\AlreadyExistsException;
use App\Exception\InvalidDateException;
use App\Repository\HomeOfficeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class HomeOfficeAdder
{
    public function __construct(
        private HomeOfficeRepository $homeOfficeRepository,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws AlreadyExistsException
     * @throws InvalidDateException
     */
    public function add(HomeOffice $homeOffice): void
    {
        $this->validate($homeOffice);

        $this->entityManager->persist($homeOffice);
        $this->entityManager->flush();

        // event Home office successfully added
        $this->eventDispatcher->dispatch(new HomeOfficeAddedEvent($homeOffice), HomeOfficeAddedEvent::NAME);
    }

    private function validate(HomeOffice $homeOffice): void
    {
        $since = $homeOffice->getSince();
        $till = $homeOffice->getTill();

        if ($this->homeOfficeRepository->countHomeOfficeInDates($since, $till, $homeOffice->getSlackUser()) > 0) {
            throw new AlreadyExistsException();
        }

        if ($since > $till) {
            throw new InvalidDateException();
        }
    }
}
