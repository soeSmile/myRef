<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;
use App\Repository\Dto\Traits\ClearTextTrait;
use DiDom\Document;

/**
 * Class NoteStoreDto
 * @package App\Repository\Dto
 */
final class NoteStoreDto extends AbstractDto
{
    use ClearTextTrait;

    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     * @throws \JsonException
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $this->setDataByKey('user_id', auth()->id());
        $this->setDataByKeyIfNull('flag', Link::FLAG_PRIVATE);
        $this->setDataByKey('type', Link::TYPE_NOTE);
        $this->setDataByKey('url', 'note');
        $this->setDataByKey('img', 'note');

        if ($this->hasKey('body')) {
            $body = $this->getDataByKey('body');
            $this->setDataByKey('body', \htmlentities($this->clearBody($body)));
            $dom = new Document($body);
            $this->setDataByKey('body_text', $dom->text());
        }

        if ($this->hasKey('tags')) {
            $tags = \json_decode($this->getDataByKey('tags'), true, 512, JSON_THROW_ON_ERROR);
            $this->setDataByKey('tags', $tags, true);
        }

        return parent::getData($abstractRepository);
    }
}