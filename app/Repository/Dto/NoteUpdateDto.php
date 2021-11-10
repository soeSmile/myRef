<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;
use App\Repository\Dto\Traits\ClearTextTrait;
use DiDom\Document;

/**
 * Class NoteUpdateDto
 * @package App\Repository\Dto
 */
final class NoteUpdateDto extends AbstractDto
{
    use ClearTextTrait;

    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $this->setDataByKey('user_id', auth()->id());
        $this->setDataByKeyIfNull('flag', Link::FLAG_PRIVAT);
        $this->setDataByKey('type', Link::TYPE_NOTE);
        $this->setDataByKey('url', 'note');

        if ($this->hasKey('body')) {
            $body = $this->getDataByKey('body');
            $this->setDataByKey('body', \htmlentities($this->clearBody($body)));
            $dom = new Document($body);
            $this->setDataByKey('body_text', $dom->text());
        }

        return parent::getData($abstractRepository);
    }
}