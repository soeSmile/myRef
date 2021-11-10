<?php
declare(strict_types=1);

namespace App\Repository\Dto\Traits;

/**
 * Trait ClearTextTrait
 */
trait ClearTextTrait
{
    /**
     * @param string $body
     * @return string
     */
    private function clearBody(string $body): string
    {
        $pattern = '/class=["|\'].*?["|\']|href=["|\'].*?["|\']/im';

        return \preg_replace($pattern, '', $body);
    }
}