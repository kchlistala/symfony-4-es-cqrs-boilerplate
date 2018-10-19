<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\IncreaseCounter\IncreaseCounterCommand;
use App\Application\Command\User\SignUp\SignUpCommand as CreateUser;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('app:gen')
        ;
    }

    /**
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 1001; $i <= 2000; $i++) {
            $uuid = $this->createUser($i);

            for ($x = 1; $x <= 200; $x++) {
                $command = new IncreaseCounterCommand($uuid);

                $this->commandBus->handle($command);
            }
        }
    }

    /**
     * @param $loopNumber
     * @return string
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    protected function createUser($loopNumber)
    {
        $command = new CreateUser(
            $uuid = Uuid::uuid4()->toString(),
            $email = 'demo'.$loopNumber.'@mail.pl',
            $password = 'password1234'
        );

        $this->commandBus->handle($command);

        return $uuid;
    }

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;
}
