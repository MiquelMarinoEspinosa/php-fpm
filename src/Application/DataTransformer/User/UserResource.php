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