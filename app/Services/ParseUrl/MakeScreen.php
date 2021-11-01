<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Log;
use Ramsey\Uuid\Uuid;

/**
 * Class MakeScreen
 */
final class MakeScreen
{
    /**
     * @param string $url
     * @return string
     */
    public function makeScreen(string $url): string
    {
        $fileName = $this->getFileName();
        $fullPath = $this->getPath() . '/' . $fileName;

        try {
            $this->request($url);
            \sleep(5);
            $response = $this->request($url);
            \file_put_contents($fullPath, $response->body());
        } catch (\Throwable $e) {
            Log::error('Error make screen', [$e->getMessage()]);
            $fileName = '';
        }

        return $fileName;
    }

    /**
     * @param string $url
     * @return Response
     */
    public function request(string $url): Response
    {
        return Http::get('https://free.pagepeeker.com/v2/thumbs.php?size=x&url=' . $this->getHost($url));
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        $dir = storage_path('app/public/screen');

        \Storage::makeDirectory($dir);

        return $dir;
    }

    /**
     * @param string $url
     * @return string
     */
    private function getHost(string $url): string
    {
        return \preg_replace('#^www\.(.+\.)#i', '$1', \parse_url($url)['host']);
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return Uuid::uuid6()->toString() . '.jpg';
    }
}