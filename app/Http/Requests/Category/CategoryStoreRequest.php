<?php
declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CategoryStoreRequest
 * @package App\Http\Requests\Category
 */
class CategoryStoreRequest extends FormRequest
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
    #[ArrayShape(['ru' => "string", 'en' => "string"])]
    public function rules(): array
    {
        return [
            'ru' => 'required|string|unique:categories',
            'en' => 'nullable|string|unique:categories',
        ];
    }
}
