<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Event;
use App\Repository\Dto\AbstractDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventRepository
 * @package App/Repository
 */
final class EventRepository extends AbstractRepository
{
    /**
     * @param Event $model
     */
    public function __construct(Event $model)
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
        if (isset($data['event'])) {
            $this->getQuery()->where('event', $data['event']);
        }

        return parent::all($data, $columns);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function storeDb(array $data): bool
    {
        return \DB::table($this->getModel()->getTable())
            ->insert($data);
    }

    /**
     * @param string $itemId
     * @param string $itemType
     * @param array $events
     * @return int
     */
    public function clearEventByItem(string $itemType, string $itemId, array $events): int
    {
        return \DB::table($this->getModel()->getTable())
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->whereIn('event', $events)
            ->delete();
    }
}