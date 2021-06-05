<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use DiDom\Document;

/**
 * Class ParseUrl
 * @package App\Services\ParseUrl
 */
class ParseUrl
{
    /**
     * @param string $url
     * @return array
     */
    public function parseUrl(string $url): array
    {
        $doc = new Document($url, true);

        return [
            'url'   => $url,
            'title' => $this->getTitle($doc),
            'desc'  => $this->getDescription($doc),
            'img'   => $this->getImage($doc),
        ];
    }

    /**
     * @param Document $document
     * @return string
     */
    private function getTitle(Document $document): string
    {
        return '';
    }

    /**
     * @param Document $document
     * @return string
     */
    private function getDescription(Document $document): string
    {
        return '';
    }

    /**
     * @param Document $document
     * @return string
     */
    private function getImage(Document $document): string
    {
        return '';
    }
}