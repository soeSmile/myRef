<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App\Models
 */
class Event extends Model
{
    use HasFactory;

    /**
     * @var int
     */
    public const EVENT_CACHE = 1;

    /**
     * @var int
     */
    public const EVENT_DATE = 2;

    /**
     * @var array
     */
    public const EVENTS = [
        self::EVENT_CACHE,
        self::EVENT_DATE
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
