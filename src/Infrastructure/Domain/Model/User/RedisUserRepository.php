<?php

namespace Php\Fpm\Infrastructure\Domain\Model\User;

use Php\Fpm\Domain\Model\User\User;
use Php\Fpm\Domain\Model\User\UserNotFound;
use Php\Fpm\Domain\Model\User\UserRepository;
use Redis;

class RedisUserRepository implements UserRepository
{
    /** @var Redis */
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function find(string $id): User
    {
        $userAsArray = json_decode(
            $this->redis->get('user_' . $id),
            true
        );

        if (null === $userAsArray) {
            throw new UserNotFound();
        }

        return new User($userAsArray['id']);
    }
}