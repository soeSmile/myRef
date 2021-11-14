<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;

/**
 * Class TagDto
 * @package App\Repository\Dto
 */
final class TagDto extends AbstractDto
{
    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $this->setDataByKey('name', \mb_strtolower($this->getDataByKey('name')));

        return parent::getData($abstractRepository);
    }
}