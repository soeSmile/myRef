<?php
declare(strict_types=1);

namespace App\Http\Requests\UserSearchLink;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class UserSearchLinkUpdateRequest
 * @package App\Http\Requests\UserSearchLink
 */
class UserSearchLinkUpdateRequest extends FormRequest
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
    #[ArrayShape(['id' => "string", 'name' => "string", 'link' => "string"])]
    public function rules(): array
    {
        return [
            'id'   => 'required|integer|exists:user_search_links',
            'name' => 'required|string',
            'link' => 'required|string',
        ];
    }
}
