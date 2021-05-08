<?php
declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryUpdateRequest
 * @package App\Http\Requests\Category
 */
class CategoryUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:categories',
            'ru' => 'required|string',
        ];
    }
}
