<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use Log;
use Ramsey\Uuid\Uuid;
use Screen\Capture;
use Screen\Exceptions\PhantomJsException;
use Screen\Image\Types\Png;

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
        $fileName = Uuid::uuid6()->toString();
        $path = storage_path('app/screen');
        $fullPath = $path . '/' . $fileName;

        try {
            $screenCapture = new Capture($url);
            $screenCapture->binPath = '/usr/local/bin/';
            $screenCapture->setOptions([
                'ssl-protocol'      => 'any',
                'ignore-ssl-errors' => 'true'
            ]);
            $screenCapture->setWidth(1100);
            $screenCapture->setHeight(700);
            $screenCapture->setClipWidth(1100);
            $screenCapture->setClipHeight(700);
            $screenCapture->setImageType(Png::FORMAT);
            $screenCapture->save($fullPath);
        } catch (PhantomJsException $e) {
            Log::error('Error make screen', [$e->getMessage()]);
            $fileName = '';
        }


        return $fileName;
    }

    private function getPrefix()
    {
        return 0;
    }
}