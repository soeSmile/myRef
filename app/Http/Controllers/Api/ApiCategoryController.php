<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        return $this->repository->all($request->all());
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