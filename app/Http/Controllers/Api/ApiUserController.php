<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserFullResource;
use App\Repository\UserRepository;
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

    public function store()
    {
    }

    public function update()
    {
    }
}