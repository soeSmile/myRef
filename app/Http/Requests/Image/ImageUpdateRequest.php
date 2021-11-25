<?php

declare(strict_types=1);

namespace App\Http\Requests\Image;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class LinkUpdateRequest
 * @package App\Http\Requests\Link
 */
class ImageUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $link = Link::find($this->get('id'));
        $owner = $link && $link->isOwner();

        return isClient() && $owner;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'file' => "string"])]
    public function rules(): array
    {
        return [
            'id'   => 'required|exists:links',
            'file' => 'required|file'
        ];
    }
}
