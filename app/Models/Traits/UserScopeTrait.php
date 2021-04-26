<?php
declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait UserScopeTrait
 * @package App\Models\Traits
 */
trait UserScopeTrait
{
    /**
     * выбор по пользователю поле user_id
     */
    protected static function bootUserScopeTrait(): void
    {
        static::addGlobalScope('user', static function (Builder $builder) {

            if (!auth()->user()->isAdmin()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }
}
