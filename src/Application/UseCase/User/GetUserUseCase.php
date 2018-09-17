<?php

namespace Php\Fpm\Application\UseCase\User;

use Php\Fpm\Application\DataTransformer\User\UserDataTransformer;
use Php\Fpm\Application\DataTransformer\User\UserResource;
use Php\Fpm\Domain\Model\User\UserNotFound;
use Php\Fpm\Domain\Model\User\UserRepository;

class GetUserUseCase
{
    /** @var UserRepository */
    private $userRepository;
    /** @var UserDataTransformer */
    private $userDataTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
    }

    public function execute(GetUserRequest $getUserRequest): UserResource
    {
        try {
            $user = $this->userRepository->find($getUserRequest->getId());

            return $this->userDataTransformer->transform($user);
        } catch (UserNotFound $userNotFound) {
            throw new CannotGetUser();
        }
    }
}