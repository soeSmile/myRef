<?php
declare(strict_types=1);

namespace App\Http\Resources\Link;

use App\Http\Resources\Category\CategorySortResource;
use App\Http\Resources\Tag\TagResource;
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
            'title'     => $this->title ?? '',
            'desc'      => $this->desc,
            'url'       => $this->url,
            'img'       => $this->img ?? '/no-image.png',
            'category'  => new CategorySortResource($this->category),
            'updatedAt' => $this->updated_at,
            'user'      => $this->getUser(),
            'tags'      => TagResource::collection($this->tags),
            'canEdit'   => $this->canEdit()
        ];

        if (isClient() && $this->isOwner()) {
            $public = \array_merge($public, [
                'user'    => new UserLinkResource($this->user),
                'comment' => $this->comment,
            ]);
        }

        if (isAdmin()) {
            $public = \array_merge($public, [
                'user'    => new UserFullResource($this->user),
                'flag'    => $this->flag,
                'comment' => $this->comment,
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
