<?php
declare(strict_types=1);

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategorySortResource
 * @package App\Http\Resources\Category
 */
class CategorySortResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $lang = app()->getLocale();

        return [
            'id'   => $this->id,
            'name' => $this->$lang,
            'icon' => $this->icon,
        ];
    }
}
