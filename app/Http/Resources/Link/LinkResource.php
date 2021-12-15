<?php

declare(strict_types=1);

namespace App\Http\Resources\Link;

use App\Http\Resources\Category\CategorySortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LinkResource
 * @package App\Http\Resources\Tag
 */
class LinkResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title ?? '',
            'url'      => $this->url,
            'img'      => $this->img,
            'category' => new CategorySortResource($this->category),
            'flag'     => $this->flag,
            'type'     => $this->type,
        ];
    }
}
