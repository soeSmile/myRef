<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;

/**
 * Class UserDto
 * @package App\Repository\Dto
 */
final class UserDto extends AbstractDto
{
    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        if ($this->hasKeyAndNull('password')) {
            $this->removeKey('password');
        } else {
            $this->setDataByKey('password', bcrypt($this->getDataByKey('password')));
        }

        return parent::getData($abstractRepository);
    }
}