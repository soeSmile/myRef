<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Link;
use App\Repository\Dto\AbstractDto;
use App\Repository\Transactions\LinkTransaction;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
     * @param array $data
     * @param array $columns
     * @return Collection|LengthAwarePaginator|array
     */
    public function all(array $data = [], array $columns = ['*']): Collection|LengthAwarePaginator|array
    {
        $this->getQuery()
            ->with('category', 'user', 'tags', 'cache', 'userLinks')
            ->withCount('userLinks');

        return parent::all($data, $columns);
    }

    /**
     * @param AbstractDto $dto
     * @return LengthAwarePaginator
     */
    public function search(AbstractDto $dto): LengthAwarePaginator
    {
        $this->getQuery()
            ->with('category', 'user', 'tags', 'cache','userLinks')
            ->withCount('userLinks');

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
                ->whereHas('userLinks', function ($query) {
                    $query->where('user_id', auth()->id());
                });
        } else {
            // остальным только публичные
            $this->getQuery()->where('flag', Link::FLAG_PUBLIC);
        }

        $this->getQuery()->latest();

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
        return DB::table(Link::TAG_TABLE)->insert($linkToTag);
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

    /**
     * @param string $userId
     * @param string $linkId
     * @return bool
     */
    public function setLinkToUser(string $userId, string $linkId): bool
    {
        return DB::table(Link::USER_LINK_TABLE)
            ->insert([
                'user_id' => $userId,
                'link_id' => $linkId
            ]);
    }

    /**
     * @param string $userId
     * @param array $linksIds
     * @return int
     */
    public function unsetLinksToUser(string $userId, array $linksIds): int
    {
        return DB::table(Link::USER_LINK_TABLE)
            ->where('user_id', $userId)
            ->whereIn('link_id', $linksIds)
            ->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        $result = false;
        $item = $this->newQuery()->find($id);

        if ($item && $item->canDelete()) {
            $result = $item->delete();
            DB::table(Link::USER_LINK_TABLE)
                ->where('link_id', $id)
                ->where('user_id', auth()->id())
                ->delete();
        }

        return $result;
    }
}