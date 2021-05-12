<?php
declare(strict_types=1);

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TagResource
 * @package App\Http\Resources\Tag
 */
class TagResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            isAdmin() && 'active'    => $this->active,
            isAdmin() && 'updatedAt' => $this->updated_at
        ];
    }
}
