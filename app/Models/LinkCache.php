<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LinkCache
 * @package App/Models
 */
class LinkCache extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
