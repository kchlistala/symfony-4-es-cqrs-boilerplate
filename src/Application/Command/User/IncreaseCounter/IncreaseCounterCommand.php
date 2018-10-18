<?php

declare(strict_types=1);

namespace App\Application\Command\User\IncreaseCounter;

use Ramsey\Uuid\Uuid;

class IncreaseCounterCommand
{
    /** @var \Ramsey\Uuid\UuidInterface */
    public $userUuid;

    /**
     * IncreaseCounterCommand constructor.
     * @param string $userUuid
     */
    public function __construct(string $userUuid)
    {
        $this->userUuid = Uuid::fromString($userUuid);
    }
}
