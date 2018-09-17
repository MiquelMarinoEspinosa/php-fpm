<?php

namespace Php\Fpm\UserInterface\Api;

use Php\Fpm\Application\UseCase\User\CannotGetUser;
use Php\Fpm\Application\UseCase\User\CreateUserRequest;
use Php\Fpm\Application\UseCase\User\CreateUserUseCase;
use Php\Fpm\Application\UseCase\User\GetUserRequest;
use Php\Fpm\Application\UseCase\User\GetUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController
{
    /** @var RequestStack */
    private $requestStack;
    /** @var GetUserUseCase */
    private $getUserUseCase;
    /** @var CreateUserUseCase */
    private $createUserUseCase;

    public function __construct(
        RequestStack $requestStack,
        GetUserUseCase $getUserUseCase,
        CreateUserUseCase $createUserUseCase
    ) {
        $this->requestStack = $requestStack;
        $this->getUserUseCase = $getUserUseCase;
        $this->createUserUseCase = $createUserUseCase;
    }

    public function getAction($userId)
    {
        try {
            $getUserRequest = new GetUserRequest($userId);
            $userResource = $this->getUserUseCase->execute(
                $getUserRequest
            );


            return new JsonResponse(
                 [
                    'user' => [
                         'id' => $userResource->getId(),
                         'name' => $userResource->getName()
                    ]
                 ]
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

    public function postAction()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $name = $currentRequest->request->get('name');

        $createUserRequest = new CreateUserRequest($name);

        $userResource = $this->createUserUseCase->execute($createUserRequest);

        return new JsonResponse(
            [
                'user' => [
                    'id' => $userResource->getId(),
                    'name' => $userResource->getName()
                ]
            ]
        );
    }
}