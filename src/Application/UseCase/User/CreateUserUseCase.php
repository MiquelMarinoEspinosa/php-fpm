<?php

namespace Php\Fpm\Application\UseCase\User;

use Php\Fpm\Application\DataTransformer\User\UserDataTransformer;
use Php\Fpm\Application\DataTransformer\User\UserResource;
use Php\Fpm\Domain\Model\User\User;
use Php\Fpm\Domain\Model\User\UserIdGenerator;
use Php\Fpm\Domain\Model\User\UserRepository;

class CreateUserUseCase
{
    /** @var UserRepository */
    private $userRepository;
    /** @var UserDataTransformer */
    private $userDataTransformer;
    /**
     * @var UserIdGenerator
     */
    private $userIdGenerator;

    public function __construct(
        UserIdGenerator $userIdGenerator,
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer
    ) {
        $this->userIdGenerator = $userIdGenerator;
        $this->userRepository = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
    }

    public function execute(CreateUserRequest $createUserRequest): UserResource
    {
        $user = new User(
            $this->userIdGenerator->generateId(),
            $createUserRequest->getName()
        );

        $this->userRepository->persist($user);

        return $this->userDataTransformer->transform($user);
    }
}