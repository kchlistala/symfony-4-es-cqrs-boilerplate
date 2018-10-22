<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\User;

use App\Application\Command\User\IncreaseCounter\IncreaseCounterCommand;
use App\Domain\User\Auth\SessionInterface;
use App\Domain\User\Exception\ForbiddenException;
use App\UI\Http\Rest\Controller\CommandController;
use League\Tactician\CommandBus;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class IncreaseCounterController extends CommandController
{
    /**
     * @Route(
     *     "/users/{uuid}/counter",
     *     name="user_increase_counter",
     *     methods={"POST"}
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Counter Increased"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Conflict"
     * )
     * @SWG\Parameter(
     *     name="change-email",
     *     type="object",
     *     in="body",
     *     required=true,
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="email", type="string")
     *     )
     * )
     * @SWG\Parameter(
     *     name="uuid",
     *     type="string",
     *     in="path"
     * )
     *
     * @SWG\Tag(name="User")
     *
     * @Security(name="Bearer")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $this->validateUuid($uuid);

        $command = new IncreaseCounterCommand($uuid);

        $this->exec($command);

        return JsonResponse::create();
    }

    private function validateUuid(string $uuid): void
    {
        if (!$this->session->sameByUuid($uuid)) {
            throw new ForbiddenException();
        }
    }

    public function __construct(SessionInterface $session, CommandBus $commandBus)
    {
        parent::__construct($commandBus);
        $this->session = $session;
    }

    /**
     * @var SessionInterface
     */
    private $session;
}
