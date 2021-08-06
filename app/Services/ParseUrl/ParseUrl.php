<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;
use Http;

/**
 * Class ParseUrl
 * @package App\Services\ParseUrl
 */
class ParseUrl
{
    /**
     * @var string
     */
    protected string $urlRoot = '';

    /**
     * @param string $url
     * @return array
     */
    public function parseUrl(string $url): array
    {
        try {
            $response = Http::get($url);
            $doc = new Document($response->body());
            $this->urlRoot = $this->getRootUrl($url);
            $head = $doc->first('head');
        } catch (\Throwable $exception) {

            \Log::error($exception->getMessage());

            return [
                'url'   => $url,
                'title' => $this->getTitle($url),
                'desc'  => $url
            ];
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
     * @return string
     */
    private function getRootUrl(string $url): string
    {
        $parse = \parse_url($url);

        return $parse['scheme'] . '://' . $parse['host'];
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
            $icons = $head->find('link[href$=ico]');

            foreach ($icons as $description) {
                $icon = $description->attr('href');
            }

            if (!$icon) {
                $icons = $head->find('link[rel=shortcut icon]');

                foreach ($icons as $description) {
                    $icon = $description->attr('href');
                }
            }
        }

        return $this->hasUrl($icon) ? $icon : $this->urlRoot . $icon;
    }

    /**
     * @param string $str
     * @return bool
     */
    private function hasUrl(string $str): bool
    {
        $parse = \parse_url($str);

        return isset($parse['scheme']);
    }
}