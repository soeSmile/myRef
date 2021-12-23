<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;

/**
 * Class LinkSearchDto
 * @package App\Repository\Dto
 */
final class LinkSearchDto extends AbstractDto
{
    /**
     * @var array
     */
    private const FIELDS = [
        'cats'   => [
            'regexp'  => '/^\[[\d,]+\]*/',
            'default' => '[]',
            'type'    => 'array',
        ],
        'tags'   => [
            'regexp'  => '/^\[[\d,]+\]*/',
            'default' => '[]',
            'type'    => 'array',
        ],
        'count'  => [
            'regexp'  => '/^\d+/',
            'default' => AbstractRepository::COUNT,
            'type'    => 'integer',
        ],
        'cat'    => [
            'regexp'  => '/^\d+/',
            'default' => 0,
            'type'    => 'integer',
        ],
        'flag'   => [
            'regexp'  => '/^(' . Link::FLAG_PUBLIC . '|' . Link::FLAG_PRIVATE . ')$/',
            'default' => Link::FLAG_PUBLIC,
            'type'    => 'integer',
        ],
        'type'   => [
            'regexp'  => '/^(' . Link::TYPE_LINK . '|' . Link::TYPE_NOTE . '|' . Link::TYPE_LINK_AND_NOTE . ')$/',
            'default' => Link::TYPE_LINK,
            'type'    => 'integer',
        ],
        'owner'  => [
            'regexp'  => '/^(true|false)$/',
            'default' => false,
            'type'    => 'boolean',
        ],
        'search' => [
            'regexp'  => '/^\w+/',
            'default' => '',
            'type'    => 'string',
        ],
    ];

    /**
     * LinkSearchDto constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->filterData();
    }

    /**
     * @return void
     */
    private function filterData(): void
    {
        $result = [];

        foreach ($this->getData() as $key => $item) {
            if (\array_key_exists($key, self::FIELDS)) {
                $result[$key] = $this->parseValue($key);
            }
        }

        $this->setData($result);
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function parseValue(string $key): mixed
    {
        $value = $this->getDataByKey($key);
        $result = self::FIELDS[$key]['default'];
        $type = self::FIELDS[$key]['type'];

        if (\preg_match(self::FIELDS[$key]['regexp'], $value)) {
            $result = $value;

            if (\in_array($key, ['cats', 'tags'])) {
                try {
                    $result = \json_decode($value, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $result = [];
                }
            }
        }


        return $this->catValueToType($result, $type);
    }

    /**
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    private function catValueToType(mixed $value, string $type): mixed
    {
        return match ($type) {
            'integer' => (int)$value,
            'boolean' => (bool)$value,
            default => $value
        };
    }
}