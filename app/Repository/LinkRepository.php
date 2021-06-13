<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $data
     * @param array|string[] $columns
     * @return Collection|LengthAwarePaginator|array
     */
    public function all(array $data = [], array $columns = ['*']): Collection|LengthAwarePaginator|array
    {
        $this->getQuery()->with('category', 'user');

        if (!auth()->check()) {
            $this->getQuery()->where('flag', Link::STATUS_PUBLIC);
        }

        if (isset($data['cats'])) {
            $cats = $this->parseStrArray($data['cats']);

            $this->getQuery()->whereHas('category', static function (Builder $query) use ($cats) {
                $query->whereIn('id', $cats);
            });
        }

        return parent::all($data, $columns);
    }

    /**
     * @param string $str
     * @return array
     */
    private function parseStrArray(string $str): array
    {
        try {
            $result = \json_decode($str, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $result = [];
        }

        return $result;
    }
}