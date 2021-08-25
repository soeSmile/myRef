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
     * @var TagRepository
     */
    public TagRepository $tag;

    /**
     * @var EventRepository
     */
    public EventRepository $event;

    /**
     * @var LinkTransaction
     */
    private LinkTransaction $transaction;

    /**
     * @param Link $model
     * @param TagRepository $tagRepository
     * @param LinkTransaction $linkTransaction
     * @param EventRepository $eventRepository
     */
    public function __construct(
        Link $model,
        TagRepository $tagRepository,
        LinkTransaction $linkTransaction,
        EventRepository $eventRepository
    ) {
        $this->tag = $tagRepository;
        $this->transaction = $linkTransaction;
        $this->event = $eventRepository;

        parent::__construct($model);
    }

    /**
     * @param AbstractDto $dto
     * @return LengthAwarePaginator
     */
    public function search(AbstractDto $dto): LengthAwarePaginator
    {
        $this->getQuery()->with('category', 'user', 'tags', 'cache');

        if (!isAdmin()) {
            $mustUser = false;
            $this->getQuery()->where('flag', $dto->getDataByKey('flag') ?? Link::FLAG_PUBLIC);

            if ($dto->getDataByKey('flag') === Link::FLAG_PRIVAT) {
                $mustUser = true;
            }

            if ($dto->hasKey('owner')) {
                $mustUser = true;
            }

            if ($mustUser && auth()->check()) {
                $this->getQuery()->where('user_id', auth()->id());
            }
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

        $type = Link::TYPE_LINK;

        if ($dto->hasKey('ref')) {
            $type = Link::TYPE_LINK;
        }

        if ($dto->hasKey('note')) {
            $type = Link::TYPE_NOTE;
        }

        if ($dto->hasKey('ref') && $dto->hasKey('note')) {
            $type = false;
            $this->getQuery()
                ->where('type', Link::TYPE_LINK)
                ->orWhere('type', Link::TYPE_NOTE);
        }

        if ($type) {
            $this->getQuery()->where('type', $type);
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
     * @param AbstractDto $dto
     * @return bool
     * @throws Throwable
     */
    public function updateTransaction(AbstractDto $dto): bool
    {
        return $this->transaction->update($this, $dto);
    }

    /**
     * @param $linkId
     * @return int
     */
    public function clearTag($linkId): int
    {
        return \DB::table(Link::TAG_TABLE)
            ->where('link_id', $linkId)
            ->delete();
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