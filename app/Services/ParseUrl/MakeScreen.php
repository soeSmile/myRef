<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use Illuminate\Support\Facades\Http;
use Log;
use Ramsey\Uuid\Uuid;

/**
 * Class MakeScreen
 */
class MakeScreen
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
            $response = Http::get('https://free.pagepeeker.com/v2/thumbs.php?size=x&url=' . $this->getHost($url));
            \file_put_contents($fullPath, $response->body());
        } catch (\Throwable $e) {
            Log::error('Error make screen', [$e->getMessage()]);
            $fileName = '';
        }

        return $fileName;
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
    private function getPath(): string
    {
        return storage_path('app/public/screen');
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return Uuid::uuid6()->toString() . '.jpg';
    }
}