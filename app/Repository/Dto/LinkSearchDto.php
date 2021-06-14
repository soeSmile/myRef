<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Repository\AbstractRepository;

/**
 * Class LinkSearchDto
 * @package App\Repository\Dto
 */
final class LinkSearchDto extends AbstractDto
{
    private const FIELDS = [
        'ref'   => [
            'regexp'  => '/[true||false]/',
            'default' => true
        ],
        'note'  => [
            'regexp'  => '/[true||false]/',
            'default' => true
        ],
        'top'   => [
            'regexp'  => '/[true||false]/',
            'default' => true
        ],
        'date'  => [
            'regexp'  => '/[true||false]/',
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
            if (\array_key_exists($key, self::FIELDS) && \preg_match(self::FIELDS[$key]['regexp'], $item)) {
                $result[$key] = $item;
            }
        }

        $this->setData($result);
    }

    /**
     * @param string $str
     * @return array
     */
    private function parseStrArray(string $str): array
    {
        try {
            $result = \json_decode($str, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $result = [];
        }

        return $result;
    }
}