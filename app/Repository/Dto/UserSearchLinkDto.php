<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\UserSearchLink;
use App\Repository\AbstractRepository;

/**
 * Class UserSearchLinkDto
 */
final class UserSearchLinkDto extends AbstractDto
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