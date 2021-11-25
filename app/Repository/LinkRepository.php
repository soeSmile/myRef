<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;
use App\Repository\Dto\AbstractDto;
use App\Repository\Transactions\LinkTransaction;
use DB;
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

        // выборка по категориям
        if ($dto->hasKey('cats')) {
            $this->getQuery()->whereIn('category_id', $dto->getDataByKey('cats'));
        }

        // выборка по категории
        if ($dto->hasKey('cat')) {
            $this->getQuery()->where('category_id', $dto->getDataByKey('cat'));
        }

        // выборка по тегам
        if ($dto->hasKey('tags')) {
            $tags = $dto->getDataByKey('tags');

            $this->getQuery()->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags);
            });
        }

        // выборка по типу
        if ($dto->hasKey('type')) {
            $type = $dto->getDataByKey('type');

            if ($type === Link::TYPE_LINK_AND_NOTE) {
                $this->getQuery()->whereIn('type', [Link::TYPE_LINK, Link::TYPE_NOTE]);
            } else {
                $this->getQuery()->where('type', $type);
            }
        }

        // только свои все
        if (isClient() && $dto->hasKey('owner')) {
            $this->getQuery()
                ->where('user_id', auth()->id())
                ->whereIn('flag', [Link::FLAG_PRIVAT, Link::FLAG_PUBLIC]);
        } else {
            // остальным только публичные
            $this->getQuery()->where('flag', Link::FLAG_PUBLIC);
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
        return DB::table(Link::TAG_TABLE)
            ->where('link_id', $linkId)
            ->delete();
    }

    /**
     * @param array $linkToTag
     * @return bool
     */
    public function storeTag(array $linkToTag): bool
    {
        return DB::table(Link::TAG_TABLE)
            ->insert($linkToTag);
    }

    /**
     * @param $id
     * @param null $file
     * @return bool
     */
    public function updateAttache($id, $file = null): bool
    {
        $item = $this->newQuery()->find($id);

        if ($item->file) {
            \Storage::delete('link/' . $item->id . '/' . $item->file);
        }

        return $item && $item->update(['file' => $file]);
    }

    /**
     * @param $id
     * @param string $image
     * @return bool
     */
    public function updateImage($id, string $image): bool
    {
        $item = $this->newQuery()->find($id);

        if ($item->img && $item->img !== 'note') {
            \Storage::delete('public/screen/' . $item->img);
        }

        return $item && $item->update(['img' => $image]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroyImage($id): bool
    {
        $item = $this->newQuery()->find($id);

        return $item && $item->update(['img' => 'note']);
    }
}