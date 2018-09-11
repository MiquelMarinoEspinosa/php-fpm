<?php

namespace Php\Cli\Tests\Unit\Application\UseCase;

use Php\Cli\Application\DataTransformer\User\UserDataTransformer;
use Php\Cli\Application\DataTransformer\User\UserResource;
use Php\Cli\Application\UseCase\GetUserRequest;
use Php\Cli\Application\UseCase\GetUserUseCase;
use Php\Cli\Domain\Model\User\User;
use Php\Cli\Domain\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;

class GetUserUseCaseTest extends TestCase
{
    public function testUserFound()
    {
        $id ='rewsd-ewqer-dsdas-qewqe';
        $user = new User($id);
        $userResource = new UserResource($id);
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
