<?php
declare(strict_types=1);

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class TagUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'name' => "array"])]
    public function rules(): array
    {
        return [
            'id'   => 'required|integer|exists:tags',
            'name' => [
                'required',
                'string',
                Rule::unique('tags')->ignore($this->request->get('id'))
            ],
        ];
    }
}
