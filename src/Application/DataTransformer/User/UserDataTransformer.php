<?php

namespace Php\Fpm\Application\DataTransformer\User;

use Php\Fpm\Domain\Model\User\User;

class UserDataTransformer
{
    public function transform(User $user): UserResource
    {
        return new UserResource(
            $user->getId(),
            $user->getName()
        );
    }
}