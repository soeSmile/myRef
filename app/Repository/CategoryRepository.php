<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repository
 */
final class CategoryRepository extends AbstractRepository
{
    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}