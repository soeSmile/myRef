<?php
declare(strict_types=1);

namespace App\Http\Requests\UserSearchLink;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules(): array
    {
        return [
            'id'   => 'required|integer|exists:user_search_links',
            'name' => 'required|string',
            'link' => 'required|string',
        ];
    }
}
