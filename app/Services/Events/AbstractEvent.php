<?php
declare(strict_types=1);

namespace App\Services\Events;

use App\Models\Event;
use Illuminate\Support\Collection;

/**
 * Class AbstractEvent
 */
abstract class AbstractEvent
{
    /**
     * @param int $event
     * @return Collection
     */
    public function getEvents(int $event): Collection
    {
        return \DB::table(Event::getModel()->getTable())
            ->where('event', $event)
            ->get();
    }

    /**
     * @param int $id
     * @return int
     */
    public function removeEvent(int $id): int
    {
        return \DB::table(Event::getModel()->getTable())
            ->delete($id);
    }
}