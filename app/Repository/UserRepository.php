<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repository
 */
final class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}