<?php

namespace Php\Fpm\Application\DataTransformer\User;

/**
 * @OA\Schema()
 */
class UserResource
{
    /**
     * @var string
     * @OA\Property(
     *   property="id",
     *   type="string",
     *   description="The user id"
     * )
     */
    private $id;

    /**
     * @var string
     * @OA\Property(
     *   property="name",
     *   type="string",
     *   description="The user name"
     * )
     */
    private $name;

    /**
     * @var string
     * @OA\Property(
     *   property="self",
     *   type="string",
     *   description="The self url resource"
     * )
     */
    private $self;

    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->self = 'https://site.org/user/' . $this->id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSelf(): string
    {
        return $this->self;
    }
}