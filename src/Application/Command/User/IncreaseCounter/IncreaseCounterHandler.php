<?php

declare(strict_types=1);

namespace App\Application\Command\User\IncreaseCounter;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class IncreaseCounterHandler implements CommandHandlerInterface
{
    public function __invoke(IncreaseCounterCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid);

        $user->increaseCounter();

        $this->userRepository->store($user);
    }

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** @var UserRepositoryInterface */
    private $userRepository;
}
