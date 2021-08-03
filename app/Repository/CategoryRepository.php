<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @param array $data
     * @param array|string[] $columns
     * @return Collection|LengthAwarePaginator|array
     */
    public function all(array $data = [], array $columns = ['*']): Collection|LengthAwarePaginator|array
    {
        $this->getQuery()->orderBy('id');

        if (isset($data['name'])) {
            $this->getQuery()->where(app()->getLocale(), 'like', $data['name'] . '%');
        }

        return parent::all($data, $columns);
    }
}