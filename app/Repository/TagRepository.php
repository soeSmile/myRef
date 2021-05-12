<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TagRepository
 * @package App\Repository
 */
final class TagRepository extends AbstractRepository
{
    /**
     * TagRepository constructor.
     * @param Tag $model
     */
    public function __construct(Tag $model)
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
        if (isset($data['name'])) {
            $this->getQuery()->where('name', 'like', $data['name'] . '%');
        }

        return parent::all($data, $columns);
    }
}