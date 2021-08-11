<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\UserSearchLink;

/**
 * Class UserSearchLinkRepository
 */
final class UserSearchLinkRepository extends AbstractRepository
{
    /**
     * @param UserSearchLink $model
     */
    public function __construct(UserSearchLink $model)
    {
        parent::__construct($model);
    }
}