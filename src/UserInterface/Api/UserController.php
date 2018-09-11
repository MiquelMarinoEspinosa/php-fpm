<?php

namespace Php\Fpm\UserInterface\Api;

use Php\Fpm\Application\UseCase\GetUserRequest;
use Php\Fpm\Application\UseCase\GetUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    /** @var Request */
    private $request;
    /** @var GetUserUseCase */
    private $getUserUseCase;

    public function __construct(
        Request $request,
        GetUserUseCase $getUserUseCase
    ) {
        $this->request = $request;
        $this->getUserUseCase = $getUserUseCase;
    }

    public function findAction($userId)
    {
        $getUserRequest = new GetUserRequest($userId);
        $userResource = $this->getUserUseCase->execute(
            $getUserRequest
        );

        return new JsonResponse(
            ['id' => $userResource->getId()]
        );
    }
}