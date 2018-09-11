<?php

namespace Php\Cli\Application\UseCase;

use Php\Cli\Application\DataTransformer\User\UserDataTransformer;
use Php\Cli\Application\DataTransformer\User\UserResource;
use Php\Cli\Domain\Model\User\UserRepository;

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
        $user = $this->userRepository->find($getUserRequest->getId());

        return $this->userDataTransformer->transform($user);
    }
}