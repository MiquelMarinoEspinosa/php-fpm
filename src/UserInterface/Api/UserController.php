<?php

namespace Php\Fpm\UserInterface\Api;

use Php\Fpm\Application\UseCase\User\CannotGetUser;
use Php\Fpm\Application\UseCase\User\CreateUserRequest;
use Php\Fpm\Application\UseCase\User\CreateUserUseCase;
use Php\Fpm\Application\UseCase\User\GetUserRequest;
use Php\Fpm\Application\UseCase\User\GetUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /** @var RequestStack */
    private $requestStack;
    /** @var GetUserUseCase */
    private $getUserUseCase;
    /** @var CreateUserUseCase */
    private $createUserUseCase;

    public function __construct(
        RequestStack $requestStack,
        GetUserUseCase $getUserUseCase,
        CreateUserUseCase $createUserUseCase
    ) {
        $this->requestStack = $requestStack;
        $this->getUserUseCase = $getUserUseCase;
        $this->createUserUseCase = $createUserUseCase;
    }

    /**
     * @OA\Info(title="User API", version="0.1")
     */

    /**
     * * @OA\Server(url="https://site.org")
     */

    /**
     * @OA\Get(
     *     path="/user/{id}",
     *     tags={"User"},
     *     @OA\Parameter(
     *        name="id",
     *        description="Id for the user",
     *        in="path",
     *        @OA\Schema(
     *              type="string"
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="User found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/UserResource"
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      format="int64",
     *                      description="The response status"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The response not detailed message"
     *                  )
     *             ),
     *         )
     *     ),
     * )
     */
    public function getAction($userId)
    {
        try {
            $getUserRequest = new GetUserRequest($userId);
            $userResource = $this->getUserUseCase->execute(
                $getUserRequest
            );


            return new JsonResponse(
                 [
                    'user' => [
                         'id' => $userResource->getId(),
                         'name' => $userResource->getName()
                    ]
                 ],
                Response::HTTP_OK,
                [
                    'Access-Control-Allow-Origin' => '*'
                ]
            );
        } catch (CannotGetUser $cannotGetUser) {
            return new JsonResponse(
                [
                    'error' => [
                        'status' => Response::HTTP_NOT_FOUND,
                        'title' => 'User not found',
                        'detail' => $cannotGetUser->getMessage()
                    ]
                ],
                Response::HTTP_NOT_FOUND,
                [
                    'Access-Control-Allow-Origin' => '*'
                ]
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => [
                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'title' => 'Internal server error',
                        'detail' => $exception->getMessage()
                    ]
                ],
                Response::HTTP_NOT_FOUND,
                [
                    'Access-Control-Allow-Origin' => '*'
                ]
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="User name",
     *                   type="string"
     *               )
     *           )
     *        )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="User created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserResource"),
     *         )
     *     ),
     *     @OA\Response(
     *          response="default",
     *          description="An error occured",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      format="int64",
     *                      description="The response status"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The response not detailed message"
     *                  )
     *             ),
     *         )
     *     ),
     * )
     */
    public function postAction()
    {
        try {
            $currentRequest = $this->requestStack->getCurrentRequest();
            $name = $currentRequest->request->get('name');

            $createUserRequest = new CreateUserRequest($name);

            $userResource = $this->createUserUseCase->execute($createUserRequest);

            return new JsonResponse(
                [
                    'user' => [
                        'id' => $userResource->getId(),
                        'name' => $userResource->getName()
                    ]
                ],
                Response::HTTP_OK,
                [
                    'Access-Control-Allow-Origin' => '*'
                ]
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => [
                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'title' => 'Internal server error',
                        'detail' => $exception->getMessage()
                    ]
                ],
                Response::HTTP_NOT_FOUND,
                [
                    'Access-Control-Allow-Origin' => '*'
                ]
            );
        }
    }
}