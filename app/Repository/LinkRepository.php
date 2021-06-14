<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;
use App\Repository\Dto\AbstractDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LinkRepository
 * @package App\Repository
 */
final class LinkRepository extends AbstractRepository
{
    /**
     * LinkRepository constructor.
     * @param Link $model
     */
    public function __construct(Link $model)
    {
        parent::__construct($model);
    }

    /**
     * @param AbstractDto $dto
     * @return LengthAwarePaginator
     */
    public function search(AbstractDto $dto): LengthAwarePaginator
    {
        $this->getQuery()->with('category', 'user');

        if (!auth()->check()) {
            $this->getQuery()->where('flag', Link::STATUS_PUBLIC);
        }

        if ($dto->hasKey('cats')) {
            $cats = $dto->getDataByKey('cats');

            $this->getQuery()->whereHas('category', static function (Builder $query) use ($cats) {
                $query->whereIn('id', $cats);
            });
        }

        return $this->getQuery()->paginate($data['count'] ?? self::COUNT);
    }
}