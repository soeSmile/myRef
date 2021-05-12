<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Http\Resources\Tag\TagResource;
use App\Repository\Dto\TagDto;
use App\Repository\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiTagController
 * @package App\Http\Controllers\Api
 */
final class ApiTagController
{
    /**
     * @var TagRepository
     */
    private TagRepository $repository;

    /**
     * ApiTagController constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->repository = $tagRepository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return TagResource::collection($this->repository->all($request->all()));
    }

    /**
     * @param $id
     * @return TagResource
     */
    public function show($id): TagResource
    {
        return new TagResource($this->repository->get($id));
    }

    /**
     * @param TagStoreRequest $request
     * @return TagResource
     */
    public function store(TagStoreRequest $request): TagResource
    {
        return new TagResource($this->repository->store(new TagDto($request->all())));
    }

    /**
     * @param $id
     * @param TagUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, TagUpdateRequest $request): JsonResponse
    {
        $result = (bool)$this->repository->update($id, new TagDto($request->all()));

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}