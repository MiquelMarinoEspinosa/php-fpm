<?php

namespace Php\Cli\Application\DataTransformer\User;

use Php\Cli\Domain\Model\User\User;

class UserDataTransformer
{
    public function transform(User $user): UserResource
    {
        return new UserResource(
            $user->getId()
        );
    }
}