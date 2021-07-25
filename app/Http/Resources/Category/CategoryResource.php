<?php
declare(strict_types=1);

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryResource
 * @package App\Http\Resources\Category
 */
class CategoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $lang = app()->getLocale();

        return [
            'id'        => $this->id,
            'ru'        => $this->ru,
            'en'        => $this->en,
            'icon'      => $this->icon,
            'active'    => $this->active,
            'updatedAt' => $this->updated_at,
            'name'      => $this->$lang,
        ];
    }
}
