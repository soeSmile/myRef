<?php
declare(strict_types=1);

namespace App\Repository\Dto;

use App\Models\Link;
use App\Repository\AbstractRepository;
use DiDom\Document;
use Ramsey\Uuid\Uuid;

/**
 * Class NoteStoreDto
 * @package App\Repository\Dto
 */
final class NoteStoreDto extends AbstractDto
{
    /**
     * @param AbstractRepository|null $abstractRepository
     * @return array
     */
    public function getData(?AbstractRepository $abstractRepository = null): array
    {
        $id = Uuid::uuid6();

        $this->setDataByKey('user_id', auth()->id());
        $this->setDataByKeyIfNull('flag', Link::FLAG_PRIVAT);
        $this->setDataByKey('type', Link::TYPE_NOTE);
        $this->setDataByKey('id', $id);
        $this->setDataByKey('url', 'note');

        if ($this->hasKey('body')) {
            $body = $this->getDataByKey('body');
            $dom = new Document($body);
            $this->setDataByKey('body', \htmlentities($body));
            $this->setDataByKey('body_text', $dom->text());
        }

        return parent::getData($abstractRepository);
    }
}