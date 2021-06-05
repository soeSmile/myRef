<?php
declare(strict_types=1);

namespace App\Http\Resources\Link;

use App\Http\Resources\Category\CategorySortResource;
use App\Http\Resources\User\UserFullResource;
use App\Http\Resources\User\UserLinkResource;
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
            'category'  => new CategorySortResource($this->category),
            'updatedAt' => $this->updated_at,
            'user'      => $this->getUser(),
        ];

        if (isClient()) {
            $public = \array_merge($public, [
                'user'    => $this->getUser(),
                'comment' => $this->comment,
                'cache'   => $this->cache,
            ]);
        }

        if (isAdmin()) {
            $public = \array_merge($public, [
                'user'    => new UserFullResource($this->user),
                'flag'    => $this->flag,
                'comment' => $this->comment,
                'cache'   => $this->cache,
            ]);
        }

        return $public;
    }

    /**
     * @return UserLinkResource|null
     */
    private function getUser(): ?UserLinkResource
    {
        if ($this->user->show) {
            return new UserLinkResource($this->user);
        }

        return null;
    }
}
