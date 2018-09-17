<?php

namespace Php\Fpm\Application\UseCase\User;

class CreateUserRequest
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;

    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}