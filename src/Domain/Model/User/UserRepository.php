<?php

namespace Php\Cli\Domain\Model\User;

interface UserRepository
{
    public function find(string $id): User;
}