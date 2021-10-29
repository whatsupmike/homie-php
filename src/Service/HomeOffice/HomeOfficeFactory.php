<?php

declare(strict_types=1);

namespace App\Service\HomeOffice;

use App\Dictionary\ModalDictionary;
use App\DTO\Payload;
use App\Entity\HomeOffice;
use App\Entity\SlackUser;

class HomeOfficeFactory
{
    private const SELECTED_DATE_KEY = 'selected_date';

    public function buildFromPayload(Payload $payload): HomeOffice
    {
        $values = $payload->getValues();

        $since = new \DateTime($values[ModalDictionary::SINCE_BLOCK_ID][ModalDictionary::SINCE_ACTION_ID][self::SELECTED_DATE_KEY]);
        $till = new \DateTime($values[ModalDictionary::TILL_BLOCK_ID][ModalDictionary::TILL_ACTION_ID][self::SELECTED_DATE_KEY]);

        return $this->build($since, $till, $payload->getUser());
    }

    public function build(\DateTime $since, \DateTime $till, SlackUser $user): HomeOffice
    {
        return (new HomeOffice())->setSince($since)->setTill($till)->setSlackUser($user);
    }
}