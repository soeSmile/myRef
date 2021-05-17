<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategorySortResource;
use App\Repository\CategoryRepository;
use App\Repository\Dto\CategoryDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiCategoryController
 * @package App\Http\Controllers\Api
 */
final class ApiCategoryController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $repository;

    /**
     * ApiCategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if (isAdmin()) {
            return CategoryResource::collection($this->repository->all($request->all()));
        }

        return CategorySortResource::collection($this->repository->all($request->all()));
    }

    /**
     * @param $id
     * @return CategoryResource
     */
    public function show($id): CategoryResource
    {
        return new CategoryResource($this->repository->get($id));
    }

    /**
     * @param CategoryStoreRequest $request
     * @return CategoryResource
     */
    public function store(CategoryStoreRequest $request): CategoryResource
    {
        return new CategoryResource($this->repository->store(new CategoryDto($request->all())));
    }

    /**
     * @param $id
     * @param CategoryUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, CategoryUpdateRequest $request): JsonResponse
    {
        $result = (bool)$this->repository->update($id, new CategoryDto($request->all()));

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}