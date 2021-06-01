<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\DataTimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLink
 * @package App\Models
 */
class TimeLink extends Model
{
    use HasFactory, DataTimeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
