<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use function array_flip;
use function array_intersect_key;
use function array_key_exists;
use function array_merge;

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
     * @var array
     */
    private array $raw;

    /**
     * @var array
     */
    private array $dataFull;

    /**
     * AbstractSerialize constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $this->snakeKeys($data);
        $this->dataFull = $this->data;
        $this->raw = $data;
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
     * @return array
     */
    public function getDataFull(): array
    {
        return $this->dataFull;
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * @param string $key
     * @param bool $full
     * @return mixed
     */
    #[Pure]
    public function getDataByKey(string $key, bool $full = false): mixed
    {
        $data = $this->data;

        if ($full) {
            $data = $this->getDataFull();
        }

        return $data[$key] ?? null;
    }

    /**
     * @param array $data
     * @return AbstractDto
     */
    public function setData(array $data): AbstractDto
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return AbstractDto
     */
    public function setDataByKey(string $key, $value): AbstractDto
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return AbstractDto
     */
    public function setDataByKeyIfNull(string $key, $value): AbstractDto
    {
        if ($this->hasKeyAndNull($key)) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return AbstractDto
     */
    public function mergeData(array $data): AbstractDto
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param string $key
     * @return AbstractDto
     */
    public function removeKey(string $key): AbstractDto
    {
        if ($this->hasKey($key)) {
            unset($this->data[$key]);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param bool $full
     * @return bool
     */
    #[Pure]
    public function hasKey(string $key, bool $full = false): bool
    {
        $data = $this->data;

        if ($full) {
            $data = $this->getDataFull();
        }

        return array_key_exists($key, $data);
    }

    /**
     * @param string $key
     * @param bool $full
     * @return bool
     */
    #[Pure]
    public function hasNull(string $key, bool $full = false): bool
    {
        return $this->getDataByKey($key, $full) === null;
    }

    /**
     * @param string $key
     * @return bool
     */
    #[Pure]
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

        return array_flip(Schema::getColumnListing($table));
    }

    /**
     * @param AbstractRepository $abstractRepository
     * @return array
     */
    public function getDiffData(AbstractRepository $abstractRepository): array
    {
        return array_intersect_key($this->data, $this->getFields($abstractRepository));
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
