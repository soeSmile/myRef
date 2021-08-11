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
    private const FIELDS = [
        'ref'   => [
            'regexp'  => '/^(true|false)$/',
            'default' => true
        ],
        'note'  => [
            'regexp'  => '/^(true|false)$/',
            'default' => true
        ],
        'top'   => [
            'regexp'  => '/^(true|false)$/',
            'default' => true
        ],
        'date'  => [
            'regexp'  => '/^(true|false)$/',
            'default' => true
        ],
        'cats'  => [
            'regexp'  => '/^\[[\d,]+\]*/',
            'default' => '[]'
        ],
        'tags'  => [
            'regexp'  => '/^\[[\d,]+\]*/',
            'default' => '[]'
        ],
        'count' => [
            'regexp'  => '/^\d+/',
            'default' => AbstractRepository::COUNT
        ],
        'cat'   => [
            'regexp'  => '/^\d+/',
            'default' => 0
        ],
        'flag'  => [
            'regexp'  => '/^(' . Link::FLAG_PUBLIC . '|' . Link::FLAG_PRIVAT . '|' . Link::FLAG_NEW . ')$/',
            'default' => Link::FLAG_PUBLIC
        ],
        'owner' => [
            'regexp'  => '/^(true|false)$/',
            'default' => false
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


        return $result;
    }
}