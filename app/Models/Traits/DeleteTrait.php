<?php
declare(strict_types=1);

namespace App\Models\Traits;

use ReflectionClass;

/**
 * Trait DeleteTrait
 * @package App\Models\Traits
 */
trait DeleteTrait
{
    /**
     * каскадное удаление
     * у модели должен быть массив deleted с данными связей для удаления
     */
    protected static function bootDeleteTrait(): void
    {
        static::deleting(static function ($model) {

            if ($model->deleted) {
                foreach ($model->deleted as $value) {
                    $type = (new ReflectionClass($model->{$value}()))->getShortName();

                    if ($type === 'BelongsToMany') {
                        $model->{$value}()->detach();
                    } else {
                        $model->{$value}()->delete();
                    }
                }
            }
        });
    }
}
