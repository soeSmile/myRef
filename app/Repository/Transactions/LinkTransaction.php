<?php
declare(strict_types=1);

namespace App\Repository\Transactions;

use App\Models\Event;
use App\Repository\AbstractRepository;
use App\Repository\Dto\AbstractDto;
use App\Repository\LinkRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Log;
use Storage;
use Throwable;

/**
 * Class LinkTransaction
 */
final class LinkTransaction extends AbstractTransaction
{
    /**
     * @param LinkRepository|AbstractRepository $repository
     * @param AbstractDto $dto
     * @return Model|null
     * @throws Throwable
     */
    public function store(LinkRepository|AbstractRepository $repository, AbstractDto $dto): ?Model
    {
        DB::beginTransaction();

        try {
            $item = $repository->store($dto);
            $this->storeTag($dto, $repository, $item->id);
            $this->storeEvent($dto, $repository, $item->id);
            $this->moveFile($dto, $item->id);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error update link', [$e->getMessage()]);
            $this->deleteFile($dto);
        }

        return $item ?? null;
    }

    /**
     * @param LinkRepository|AbstractRepository $repository
     * @param AbstractDto $dto
     * @return bool
     * @throws Throwable
     */
    public function update(LinkRepository|AbstractRepository $repository, AbstractDto $dto): bool
    {
        $result = true;

        DB::beginTransaction();

        try {
            $id = $dto->getDataByKey('id');
            $repository->update($id, $dto);
            $this->storeTag($dto, $repository, $id, true);
            $this->storeEvent($dto, $repository, $id, true);
            $this->moveFile($dto, $id);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error update link', [$e->getMessage()]);
            $result = false;
            $this->deleteFile($dto);
        }

        return $result;
    }

    /**
     * @param AbstractDto $dto
     * @param LinkRepository $repository
     * @param $id
     * @param bool $clear
     */
    private function storeTag(AbstractDto $dto, LinkRepository $repository, $id, bool $clear = false): void
    {
        $array = [];

        if (!$dto->hasNull('tags', true)) {
            $tags = $repository->tag->storeOnlyNew($dto->getDataByKey('tags', true));

            foreach ($tags as $key => $tag) {
                $array[$key]['link_id'] = $id;
                $array[$key]['tag_id'] = $tag;
            }

            if ($clear) {
                $repository->clearTag($id);
            }

            $repository->storeTag($array);
        }
    }

    /**
     * @param AbstractDto $dto
     * @param LinkRepository $repository
     * @param $id
     * @param bool $clear
     */
    private function storeEvent(AbstractDto $dto, LinkRepository $repository, $id, bool $clear = false): void
    {
        $array = [];

        if (!$dto->hasNull('date', true)) {
            $date = $dto->getDataByKey('date', true);
            $array[] = [
                'item_type' => $repository->getModel()::class,
                'item_id'   => $id,
                'event'     => Event::EVENT_DATE,
                'date'      => Carbon::parse($date, auth()->user()->time_zone)->format('Y-m-d')
            ];
        }

        if (!$dto->hasNull('cache', true) && $dto->getDataByKey('cache', true)) {
            $array[] = [
                'item_type' => $repository->getModel()::class,
                'item_id'   => $id,
                'event'     => Event::EVENT_CACHE,
                'date'      => null
            ];
        }

        if ($array !== []) {
            if ($clear) {
                $repository->event->clearEventByItem($repository->getModel()::class, $id, Event::EVENTS);
            }

            $repository->event->storeDb($array);
        }
    }

    /**
     * @param AbstractDto $dto
     * @param $id
     */
    private function moveFile(AbstractDto $dto, $id): void
    {
        if ($dto->hasKey('file')) {
            $from = $dto->getDataByKey('path', true);
            $to = 'link/' . $id . '/' . $dto->getDataByKey('file');
            Storage::move($from, $to);
            $this->deleteFile($dto);
        }
    }

    /**
     * @param AbstractDto $dto
     */
    private function deleteFile(AbstractDto $dto): void
    {
        if ($dto->hasKey('path', true)) {
            Storage::delete($dto->getDataByKey('path', true));
        }
    }
}