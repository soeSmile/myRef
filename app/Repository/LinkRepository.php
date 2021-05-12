<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;

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
}