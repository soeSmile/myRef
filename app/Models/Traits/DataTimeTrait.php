<?php
declare(strict_types=1);

namespace App\Models\Traits;

use Carbon\Carbon;

/**
 * Trait DataTimeTrait
 * Изменение дат в зависимости от временной зоны пользователя
 *
 * @package App\Models\Traits
 */
trait DataTimeTrait
{
    /**
     * изменение поля created_at
     *
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date): string
    {
        $tz = auth()->check() ? auth()->user()->time_zone : null;

        return $date ? Carbon::parse($date)->timezone($tz ?? 3)->format('H:i:s d-m-Y') : '';
    }


    /**
     * изменение поля updated_at
     *
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date): string
    {
        $tz = auth()->check() ? auth()->user()->time_zone : null;

        return $date ? Carbon::parse($date)->timezone($tz ?? 3)->format('H:i:s d-m-Y') : '';
    }
}
