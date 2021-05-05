<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Category\CategoryResource;
use App\Repository\CategoryRepository;
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
        return CategoryResource::collection($this->repository->all($request->all()));
    }

    public function show($id)
    {
    }

    public function store()
    {
    }

    public function update()
    {
    }
}