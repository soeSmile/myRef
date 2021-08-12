<?php
declare(strict_types=1);

namespace App\Http\Resources\UserSearchLink;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserSearchLinkResource
 * @package App\Http\Resources\User
 */
class UserSearchLinkResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'link' => $this->link,
        ];
    }
}
