<?php

namespace App\Entity;

use App\Repository\HomeOfficeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeOfficeRepository::class)
 */
class HomeOffice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTime $since;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTime $till;

    /**
     * @ORM\ManyToOne(targetEntity=SlackUser::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SlackUser $slackUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSince(): \DateTime
    {
        return $this->since;
    }

    public function setSince(\DateTime $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function getTill(): \DateTime
    {
        return $this->till;
    }

    public function setTill(\DateTime $till): self
    {
        $this->till = $till;

        return $this;
    }

    public function getSlackUser(): SlackUser
    {
        return $this->slackUser;
    }

    public function setSlackUser(SlackUser $slackUser): self
    {
        $this->slackUser = $slackUser;

        return $this;
    }
}
