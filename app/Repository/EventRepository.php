<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Event;
use App\Repository\Dto\AbstractDto;
use Illuminate\Database\Eloquent\Builder;
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
     * @return bool
     */
    public function storeDb(array $data): bool
    {
        return \DB::table($this->getModel()->getTable())
            ->insert($data);
    }
}