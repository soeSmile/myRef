<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\DataTimeTrait;
use App\Models\Traits\UuidIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public const FLAG_NEW = 'new';

    /**
     * @var string
     */
    public const FLAG_PRIVAT = 'privat';

    /**
     * @var string
     */
    public const FLAG_PUBLIC = 'public';

    /**
     * @var string
     */
    public const TAG_TABLE = 'link_to_tag';

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

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, self::TAG_TABLE);
    }

    /**
     * @return HasOne
     */
    public function cache(): HasOne
    {
        return $this->hasOne(LinkCache::class);
    }

    /**
     * @return bool
     */
    public function isOwner(): bool
    {
        if (auth()->check()) {
            return $this->user_id === auth()->id();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function canEdit(): bool
    {
        if (auth()->check()) {
            return $this->user_id === auth()->id();
        }

        return false;
    }
}
