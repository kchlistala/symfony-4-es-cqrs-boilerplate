<?php

declare(strict_types=1);

namespace App\Domain\User\Event;

use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserCounterIncreased implements Serializable
{
    /**
     * UserCounterInreased constructor.
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return UserCounterIncreased
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');

        return new self(Uuid::fromString($data['uuid']));
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid,
        ];
    }

    /**
     * @var UuidInterface
     */
    public $uuid;
}
