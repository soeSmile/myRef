<?php
declare(strict_types=1);

namespace App\Repository\Transactions;

use App\Repository\AbstractRepository;
use App\Repository\Dto\AbstractDto;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractTransaction
 * @package
 */
abstract class AbstractTransaction
{
    /**
     * @param AbstractRepository $repository
     * @param AbstractDto $dto
     * @return Model|null
     */
    abstract public function store(AbstractRepository $repository, AbstractDto $dto): ?Model;

    /**
     * @param AbstractRepository $repository
     * @param AbstractDto $dto
     * @return bool
     */
    abstract public function update(AbstractRepository $repository, AbstractDto $dto): bool;
}