<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSearchLink
 * @package App/Models
 */
class UserSearchLink extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @param bool $next
     * @return int
     */
    public function getOrder(bool $next = false): int
    {
        $item = self::query()
            ->where('user_id', auth()->id())
            ->latest('order')
            ->first();

        $order = $item->order ?? 1;

        return $next ? ++$order : $order;
    }
}
