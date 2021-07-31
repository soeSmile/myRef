<?php
declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;
use App\Repository\Dto\AbstractDto;
use App\Repository\Transactions\LinkTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class LinkRepository
 * @package App\Repository
 */
final class LinkRepository extends AbstractRepository
{
    /**
     * @var TimeLinkRepository
     */
    public TimeLinkRepository $timeLink;

    /**
     * @var TagRepository
     */
    public TagRepository $tag;

    /**
     * @var LinkTransaction
     */
    private LinkTransaction $transaction;

    /**
     * @param Link $model
     * @param TimeLinkRepository $linkRepository
     * @param TagRepository $tagRepository
     * @param LinkTransaction $linkTransaction
     */
    public function __construct(
        Link $model,
        TimeLinkRepository $linkRepository,
        TagRepository $tagRepository,
        LinkTransaction $linkTransaction
    ) {
        $this->timeLink = $linkRepository;
        $this->tag = $tagRepository;
        $this->transaction = $linkTransaction;

        parent::__construct($model);
    }

    /**
     * @param AbstractDto $dto
     * @return LengthAwarePaginator
     */
    public function search(AbstractDto $dto): LengthAwarePaginator
    {
        $this->getQuery()->with('category', 'user', 'tags');

        if (!auth()->check()) {
            $this->getQuery()->where('flag', Link::STATUS_PUBLIC);
        }

        if ($dto->hasKey('cats')) {
            $this->getQuery()->whereIn('category_id', $dto->getDataByKey('cats'));
        }

        if ($dto->hasKey('tags')) {
            $tags = $dto->getDataByKey('tags');
            $this->getQuery()->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags);
            });
        }

        if ($dto->hasKey('cat')) {
            $this->getQuery()->where('category_id', $dto->getDataByKey('cat'));
        }

        return $this->getQuery()->paginate($dto->getDataByKey('count') ?? self::COUNT);
    }

    /**
     * @param AbstractDto $dto
     * @return Model|null
     * @throws Throwable
     */
    public function storeTransaction(AbstractDto $dto): ?Model
    {
        return $this->transaction->store($this, $dto);
    }

    /**
     * @param array $linkToTag
     * @return bool
     */
    public function storeTag(array $linkToTag): bool
    {
        return \DB::table(Link::TAG_TABLE)
            ->insert($linkToTag);
    }
}