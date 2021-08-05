<?php
declare(strict_types=1);

namespace App\Repository\Transactions;

use App\Repository\AbstractRepository;
use App\Repository\Dto\AbstractDto;
use App\Repository\LinkRepository;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class LinkTransaction
 */
final class LinkTransaction extends AbstractTransaction
{
    /**
     * @param LinkRepository|AbstractRepository $repository
     * @param AbstractDto $dto
     * @return Model
     * @throws Throwable
     */
    public function store(LinkRepository|AbstractRepository $repository, AbstractDto $dto): Model
    {
        \DB::beginTransaction();

        try {
            $item = $repository->store($dto);

            if (!$dto->hasNull('tags', true)) {
                $tags = $repository->tag->storeOnlyNew($dto->getDataByKey('tags', true));

                $array = [];
                foreach ($tags as $key => $tag) {
                    $array[$key]['link_id'] = $item->id;
                    $array[$key]['tag_id'] = $tag;
                }

                $repository->storeTag($array);
            }

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollBack();

            throw $e;
        }

        return $item;
    }

    /**
     * @param LinkRepository|AbstractRepository $repository
     * @param AbstractDto $dto
     * @return bool
     * @throws Throwable
     */
    public function update(LinkRepository|AbstractRepository $repository, AbstractDto $dto): bool
    {
        \DB::beginTransaction();

        try {
            $id = $dto->getDataByKey('id');
            $repository->update($id, $dto);
            $repository->clearTag($id);

            if (!$dto->hasNull('tags', true)) {
                $tags = $repository->tag->storeOnlyNew($dto->getDataByKey('tags', true));

                $array = [];
                foreach ($tags as $key => $tag) {
                    $array[$key]['link_id'] = $id;
                    $array[$key]['tag_id'] = $tag;
                }

                $repository->storeTag($array);
            }

            \DB::commit();
        } catch (Throwable $exception) {
            \DB::rollBack();

            throw $exception;
        }

        return true;
    }
}