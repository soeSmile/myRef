<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Class AbstractSerialize
 * @package App\Repository\Serialize
 */
abstract class AbstractDto
{
    /**
     * @var array
     */
    private array $data;

    /**
     * AbstractSerialize constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $this->snakeKeys($data);
    }

    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        if ($abstractRepository) {
            $this->setData($this->getDiffData($abstractRepository));
        }

        return $this->data;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getDataByKey(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setDataByKey(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function removeKey(string $key): void
    {
        if ($this->hasKey($key)) {
            unset($this->data[$key]);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        return \array_key_exists($key, $this->data);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasNull(string $key): bool
    {
        return !(bool)$this->getDataByKey($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasKeyAndNull(string $key): bool
    {
        return $this->hasKey($key) && $this->hasNull($key);
    }

    /**
     * @param AbstractRepository $abstractRepository
     * @return array
     */
    public function getFields(AbstractRepository $abstractRepository): array
    {
        $table = $abstractRepository->getModel()->getTable();

        return \array_flip(Schema::getColumnListing($table));
    }

    /**
     * @param AbstractRepository $abstractRepository
     * @return array
     */
    public function getDiffData(AbstractRepository $abstractRepository): array
    {
        return \array_intersect_key($this->data, $this->getFields($abstractRepository));
    }

    /**
     * @param $array
     * @param string $delimiter
     * @return array
     */
    public function snakeKeys($array, string $delimiter = '_'): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->snakeKeys($value, $delimiter);
            }
            $result[Str::snake($key, $delimiter)] = $value;
        }
        return $result;
    }
}
