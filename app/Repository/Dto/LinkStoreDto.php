<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;
use App\Services\ParseUrl\ParseUrl;

/**
 * Class LinkStoreDto
 * @package App\Repository\Dto
 */
final class LinkStoreDto extends AbstractDto
{
    /**
     * @var ParseUrl
     */
    private ParseUrl $parser;

    /**
     * LinkDto constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->parser = new ParseUrl();

        parent::__construct($data);
    }

    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $data = $this->parser->parseUrl($this->getDataByKey('url'));
        $this->mergeData($data);
        $this->setDataByKey('user_id', auth()->id());
        $this->setDataByKey('flag', Link::FLAG_PRIVAT);

        if ($this->hasKeyAndNull('category_id')) {
            $this->setDataByKey('flag', Link::FLAG_NEW);
        }

        return parent::getData($abstractRepository);
    }
}