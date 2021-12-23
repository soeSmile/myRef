<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\DataTimeTrait;
use App\Models\Traits\DeleteTrait;
use App\Models\Traits\UuidIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $title
 * @property string $desc
 * @property string $url
 * @property string $img
 * @property int category_id
 * @property string $user_id
 * @property int $flag
 * @property string $comment
 * @property int $type
 * @property string $body
 * @property string $body_text
 * @property string $created_at
 * @property string $updated_at
 * @property string $file
 *
 * @property-read BelongsTo $category
 * @property-read BelongsTo $user
 * @property-read BelongsToMany $tags
 * @property-read HasOne $cache
 * @property-read BelongsToMany $userLinks
 *
 * Class Link
 * @package App\Models
 */
class Link extends Model
{
    use DataTimeTrait;
    use DeleteTrait;
    use HasFactory;
    use UuidIdTrait;

    /**
     * @var int
     */
    public const FLAG_PRIVATE = 1;

    /**
     * @var int
     */
    public const FLAG_PUBLIC = 2;

    /**
     * @var int
     */
    public const TYPE_LINK = 1;

    /**
     * @var int
     */
    public const TYPE_NOTE = 2;

    /**
     * @var int
     */
    public const TYPE_LINK_AND_NOTE = 3;

    /**
     * @var string
     */
    public const TAG_TABLE = 'link_to_tag';

    /**
     * @var string
     */
    public const USER_LINK_TABLE = 'user_to_links';

    /**
     * @var int
     */
    public const MAX_NOTE_FILE = 2048;

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
     * @var array
     */
    protected array $deleted = [
        'tags',
        'cache'
    ];

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
     * @return BelongsToMany
     */
    public function userLinks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, self::USER_LINK_TABLE);
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

    /**
     * @return bool
     */
    public function canDelete(): bool
    {
        $result = false;

        if (auth()->check()) {
            $result = \DB::table(Link::USER_LINK_TABLE)
                ->where('link_id', $this->id)
                ->where('user_id', '<>', auth()->id())
                ->exists();
        }

        return !$result;
    }
}
