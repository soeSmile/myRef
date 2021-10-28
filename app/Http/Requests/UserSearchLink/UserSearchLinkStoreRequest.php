<?php
declare(strict_types=1);

namespace App\Http\Requests\UserSearchLink;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class UserSearchLinkStoreRequest
 * @package App\Http\Requests\UserSearchLink
 */
class UserSearchLinkStoreRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'link' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'link' => 'required|string',
        ];
    }
}
