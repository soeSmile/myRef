<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserFullResource;
use App\Repository\Dto\UserDto;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiUserController
 * @package App\Http\Controllers\Api
 */
final class ApiUserController
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * ApiUserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserFullResource::collection($this->repository->all($request->all()));
    }

    /**
     * @param $id
     * @return UserFullResource
     */
    public function show($id): UserFullResource
    {
        return new UserFullResource($this->repository->get($id));
    }

    /**
     * @param UserStoreRequest $request
     * @return UserFullResource
     */
    public function store(UserStoreRequest $request): UserFullResource
    {
        return new UserFullResource($this->repository->store(new UserDto($request->all())));
    }

    /**
     * @param $id
     * @param UserUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, UserUpdateRequest $request): JsonResponse
    {
        $result = (bool)$this->repository->update($id, new UserDto($request->all()));

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}