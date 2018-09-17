<?php

namespace Php\Fpm\Tests\Unit\Application\UseCase;

use Php\Fpm\Application\DataTransformer\User\UserDataTransformer;
use Php\Fpm\Application\DataTransformer\User\UserResource;
use Php\Fpm\Application\UseCase\User\GetUserRequest;
use Php\Fpm\Application\UseCase\User\GetUserUseCase;
use Php\Fpm\Domain\Model\User\User;
use Php\Fpm\Domain\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;

class GetUserUseCaseTest extends TestCase
{
    public function testUserFound()
    {
        $id ='rewsd-ewqer-dsdas-qewqe';
        $name = 'miquel';
        $user = new User($id, $name);
        $userResource = new UserResource($id, $name);
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->find($id)->shouldBeCalled()->willReturn($user);
        $userDataTransformer = $this->prophesize(UserDataTransformer::class);
        $userDataTransformer->transform($user)->shouldBeCalled()->willReturn($userResource);
        $useCase = new GetUserUseCase(
            $userRepository->reveal(),
            $userDataTransformer->reveal()
        );
        $request = new GetUserRequest($id);
        $this->assertEquals(
            $userResource,
            $useCase->execute($request)
        );
    }
}
