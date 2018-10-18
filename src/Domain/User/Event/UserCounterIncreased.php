<?php

declare (strict_types=1);

namespace App\Domain\User\Event;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Broadway\Serializer\Serializable;

class UserCounterIncreased implements Serializable
{
    /**
     * UserCounterInreased constructor.
     * @param UuidInterface $uuid
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param array $data
     * @return UserCounterIncreased
     * @throws \Assert\AssertionFailedException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');

        return new self(Uuid::fromString($data['uuid']));
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid
        ];
    }

    /**
     * @var UuidInterface
     */
    public $uuid;
}
