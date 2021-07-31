<?php
declare(strict_types=1);

namespace App\Repository\Transactions;

use App\Repository\AbstractRepository;
use App\Repository\Dto\AbstractDto;
use App\Repository\Dto\TimeLinkDto;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class LinkTransaction
 */
final class LinkTransaction extends AbstractTransaction
{
    /**
     * @param AbstractRepository $repository
     * @param AbstractDto $dto
     * @return Model
     * @throws Throwable
     */
    public function store(AbstractRepository $repository, AbstractDto $dto): Model
    {
        \DB::beginTransaction();

        try {
            $item = $repository->store($dto);

            if ($dto->hasKey('date')) {
                $repository->timeLink->store(new TimeLinkDto([
                    'link_id' => $item->id,
                    'time'    => $dto->getDataByKey('date')
                ]));
            }

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollBack();
            $item = null;
        }

        return $item;
    }

    /**
     * @param AbstractRepository $repository
     * @param AbstractDto $dto
     * @return bool
     */
    public function update(AbstractRepository $repository, AbstractDto $dto): bool
    {
        return true;
    }
}