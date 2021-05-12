<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\DataTimeTrait;
use App\Models\Traits\UuidIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 * @package App\Models
 */
class Link extends Model
{
    use HasFactory, DataTimeTrait, UuidIdTrait;

    /**
     * @var string
     */
    public const STATUS_NEW = 'new';

    /**
     * @var string
     */
    public const STATUS_PRIVAT = 'privat';

    /**
     * @var string
     */
    public const STATUS_PUBLIC = 'public';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $keyType = 'uuid';
}
