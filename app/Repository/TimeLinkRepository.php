<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\TimeLink;

/**
 * Class TimeLinkRepository
 * @package App\Repository
 */
final class TimeLinkRepository extends AbstractRepository
{
    /**
     * @param TimeLink $model
     */
    public function __construct(TimeLink $model)
    {
        parent::__construct($model);
    }
}