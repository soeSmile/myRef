<?php
declare(strict_types=1);

namespace App\Http\Resources\LinkCache;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LinkShortCacheResource
 * @package App\Http\Resources\LinkCache
 */
class LinkShortCacheResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => \html_entity_decode($this->data ?? '')
        ];
    }
}
