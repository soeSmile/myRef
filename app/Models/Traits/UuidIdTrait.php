<?php
declare(strict_types=1);

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Trait UuidID
 * @package App\Models\Traits
 */
trait UuidIdTrait
{
    /**
     * генерация id пользователя
     */
    protected static function bootUuidIdTrait(): void
    {
        static::creating(function ($model) {

            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
