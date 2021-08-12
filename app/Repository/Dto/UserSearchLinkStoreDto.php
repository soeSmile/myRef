<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;

/**
 * Class UserSearchLinkStoreDto
 */
final class UserSearchLinkStoreDto extends AbstractDto
{
    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $this->setDataByKey('user_id', auth()->id());

        $this->setDataByKey('order', $abstractRepository ? $abstractRepository->getModel()->getOrder(true) : 1);

        return parent::getData($abstractRepository);
    }
}