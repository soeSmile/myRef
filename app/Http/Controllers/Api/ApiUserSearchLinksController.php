<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserSearchLink\UserSearchLinkStoreRequest;
use App\Http\Requests\UserSearchLink\UserSearchLinkUpdateRequest;
use App\Http\Resources\UserSearchLink\UserSearchLinkResource;
use App\Repository\Dto\UserSearchLinkStoreDto;
use App\Repository\Dto\UserSearchLinkUpdateDto;
use App\Repository\UserSearchLinkRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiUserSearchLinksController
 * @package App\Http\Controllers\Api;
 */
class ApiUserSearchLinksController
{
    /**
     * @var UserSearchLinkRepository
     */
    private UserSearchLinkRepository $userLinks;

    /**
     * @param UserSearchLinkRepository $repository
     */
    public function __construct(UserSearchLinkRepository $repository)
    {
        $this->userLinks = $repository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserSearchLinkResource::collection($this->userLinks->all($request->all()));
    }

    /**
     * @param UserSearchLinkStoreRequest $request
     * @return UserSearchLinkResource
     */
    public function store(UserSearchLinkStoreRequest $request): UserSearchLinkResource
    {
        return new UserSearchLinkResource($this->userLinks->store(new UserSearchLinkStoreDto($request->all())));
    }

    /**
     * @param UserSearchLinkUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UserSearchLinkUpdateRequest $request, $id): JsonResponse
    {
        $result = (bool)$this->userLinks->update($id, new UserSearchLinkUpdateDto($request->all()));

        return response()->json(['success' => $result], $result ? 200 : 400);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id): JsonResponse
    {
        $result = (bool)$this->userLinks->destroy($id);

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}