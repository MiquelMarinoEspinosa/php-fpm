<?php

namespace Php\Fpm\Domain\Model\User;

interface UserIdGenerator
{
    public function generateId(): string;
}