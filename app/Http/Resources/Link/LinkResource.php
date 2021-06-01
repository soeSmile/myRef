<?php
declare(strict_types=1);

namespace App\Http\Resources\Link;

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
        $public = [
            'id'        => $this->id,
            'title'     => $this->title,
            'desc'      => $this->desc,
            'url'       => $this->url,
            'img'       => $this->img,
            'category'  => $this->category,
            'updatedAt' => $this->updated_at,
        ];

        if (isClient()) {
            $public = \array_merge($public, [
                'user'    => $this->user,
                'comment' => $this->comment,
                'cache'   => $this->cache,
            ]);
        }

        if (isAdmin()) {
            $public = \array_merge($public, [
                'user'    => $this->user,
                'flag'    => $this->flag,
                'comment' => $this->comment,
                'cache'   => $this->cache,
            ]);
        }

        return $public;
    }
}
