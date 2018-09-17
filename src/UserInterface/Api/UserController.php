<?php

namespace Php\Fpm\UserInterface\Api;

use Php\Fpm\Application\UseCase\CannotGetUser;
use Php\Fpm\Application\UseCase\GetUserRequest;
use Php\Fpm\Application\UseCase\GetUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController
{
    /** @var RequestStack */
    private $request;
    /** @var GetUserUseCase */
    private $getUserUseCase;

    public function __construct(
        RequestStack $request,
        GetUserUseCase $getUserUseCase
    ) {
        $this->request = $request;
        $this->getUserUseCase = $getUserUseCase;
    }

    public function findAction($userId)
    {
        try {
            $getUserRequest = new GetUserRequest($userId);
            $userResource = $this->getUserUseCase->execute(
                $getUserRequest
            );

            return new JsonResponse(
                ['id' => $userResource->getId()]
            );
        } catch (CannotGetUser $cannotGetUser) {
            return new JsonResponse(
                ['error' => [
                        'status' => 404,
                        'title' => 'User not found'
                    ]
                ]
            );
        }
    }
}