<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\SlackUser;

class Payload
{
    private array $payload;

    private SlackUser $user;

    private array $values;

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return array
     */
    public function getUser(): SlackUser
    {
        return $this->user;
    }

    public function setUser(SlackUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }
}