<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use DiDom\Document;
use Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use function parse_url;

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
    #[ArrayShape(['url' => "string", 'title' => "string", 'desc' => "string"])]
    public function parseUrl(string $url): array
    {
        try {
            $response = Http::get($url);
            $doc = new Document($response->body());
            $this->urlRoot = $this->getRootUrl($url);
            $head = $doc->first('head');
        } catch (Throwable $exception) {

            Log::error($exception->getMessage());

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
        ];
    }

    /**
     * @param string $url
     * @return string
     */
    private function getRootUrl(string $url): string
    {
        $parse = parse_url($url);

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
}