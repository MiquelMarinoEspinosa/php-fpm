<?php

namespace Php\Fpm\Infrastructure\Domain\Model\User;

use Php\Fpm\Domain\Model\User\UserIdGenerator;
use Ramsey\Uuid\Uuid;

class UuidUserIdGenerator implements UserIdGenerator
{
    public function generateId(): string
    {
        return Uuid::uuid4();
    }
}