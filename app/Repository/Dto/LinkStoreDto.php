<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;

/**
 * Class LinkStoreDto
 * @package App\Repository\Dto
 */
final class LinkStoreDto extends AbstractDto
{
    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $this->setDataByKey('user_id', auth()->id());
        $this->setDataByKeyIfNull('flag', Link::FLAG_PRIVATE);

        return parent::getData($abstractRepository);
    }
}