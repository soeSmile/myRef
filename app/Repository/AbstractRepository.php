<?php
declare(strict_types=1);

namespace App\Repository;

use App\Repository\Dto\AbstractDto;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 * @package App\Repository
 */
abstract class AbstractRepository
{
    /**
     * @var int
     */
    public const COUNT = 20;

    /**
     * @var int
     */
    public const MAX_COUNT = 100;

    /**
     * @var Model
     */
    private Model $model;

    /**
     * @var Builder
     */
    private Builder $query;


    /**
     * AbstractRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model::query();
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * @return $this
     */
    public function newQuery(): self
    {
        $this->query = $this->model::query();

        return $this;
    }

    /**
     * @param array $data
     * @param array $columns
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function all(array $data = [], array $columns = ['*']): Collection|LengthAwarePaginator|array
    {
        if (isset($data['count']) && $data['count'] > 0) {
            return $this->query->paginate($this->getCountPaginate((int)$data['count']), $columns);
        }

        return $this->query->get($columns);
    }

    /**
     * @param int $count
     * @return int
     */
    public function getCountPaginate(int $count): int
    {
        return $count > self::MAX_COUNT ? self::COUNT : $count;
    }

    /**
     * @param mixed $id
     * @return Model|Builder
     */
    public function get(mixed $id): Model|Builder
    {
        return $this->query->where('id', $id)->firstOrFail();
    }

    /**
     * @param AbstractDto $dto
     * @return Builder|Model
     */
    public function store(AbstractDto $dto): Model|Builder
    {
        return $this->query->create($dto->getData($this));
    }

    /**
     * @param $id
     * @param AbstractDto $dto
     * @return bool|int
     */
    public function update($id, AbstractDto $dto): bool|int
    {
        $item = $this->query->find($id);

        return $item ? $item->update($dto->getData($this)) : false;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function destroy($id): mixed
    {
        $item = $this->query->find($id);

        return $item ? $item->delete() : false;
    }

    /**
     * @param array $data
     * @param string $column
     * @return mixed
     */
    public function destroyMass(array $data, string $column = 'id'): mixed
    {
        return $this->query->whereIn($column, $data)->delete();
    }
}
