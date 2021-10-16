<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\HomeOffice;
use Symfony\Contracts\EventDispatcher\Event;

class HomeOfficeAddedEvent extends Event
{
    public const NAME = 'homeOffice.added';

    public function __construct(private HomeOffice $homeOffice)
    {
    }

    public function getHomeOffice(): HomeOffice
    {
        return $this->homeOffice;
    }
}