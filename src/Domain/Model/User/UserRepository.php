<?php

namespace Php\Fpm\Domain\Model\User;

interface UserRepository
{
    public function find(string $id): User;

    public function persist(User $user);
}