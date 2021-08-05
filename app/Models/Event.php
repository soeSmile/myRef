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
     * @var string[]
     */
    protected $guarded = ['id'];
}
