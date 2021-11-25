<?php

declare(strict_types=1);

namespace App\Http\Requests\Image;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LinkUpdateRequest
 * @package App\Http\Requests\Link
 */
class ImageDestroyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $link = Link::find($this->route()->image);
        $owner = $link && $link->isOwner();

        return isClient() && $owner;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
        ];
    }
}
