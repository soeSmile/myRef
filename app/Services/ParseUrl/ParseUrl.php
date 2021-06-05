<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;
use JetBrains\PhpStorm\ArrayShape;

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
    #[ArrayShape(['url' => "string", 'title' => "string", 'desc' => "string", 'img' => "string"])]
    public function parseUrl(
        string $url
    ): array {
        $doc = new Document($url, true);

        try {
            $head = $doc->first('head');
        } catch (InvalidSelectorException $e) {
            $head = null;
        }

        return [
            'url'   => $url,
            'title' => $this->getTitle($url, $head),
            'desc'  => $this->getDescription($head),
            'img'   => $this->getImage($head),
        ];
    }

    /**
     * @param string $url
     * @param null $head
     * @return string
     */
    private function getTitle(string $url, $head = null): string
    {
        $title = $url;

        if ($head) {
            $titles = $head->find('title');

            foreach ($titles as $node) {
                $title = $node->text();
            }
        }

        return $title;
    }

    /**
     * @param null $head
     * @return string
     */
    private function getDescription($head = null): string
    {
        $desc = '';

        if ($head) {
            $descriptions = $head->find('meta[name=description]');

            foreach ($descriptions as $description) {
                $desc = $description->attr('content');
            }
        }

        return $desc;
    }

    /**
     * @param $head
     * @return string
     */
    private function getImage($head): string
    {
        $icon = '';

        if ($head) {
            $icons = $head->find('link[rel=icon]');

            foreach ($icons as $description) {
                $icon = $description->attr('href');
            }
        }

        return $icon;
    }
}