<?php
declare(strict_types=1);

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'ru'        => $this->ru,
            'en'        => $this->en,
            'active'    => $this->active,
            'updatedAt' => $this->updated_at
        ];
    }
}
