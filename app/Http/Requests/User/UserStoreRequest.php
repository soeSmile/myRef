<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class UserStoreRequest
 */
class UserStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return isAdmin();
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'name'     => "string",
        'email'    => "string",
        'confirm'  => "string",
        'password' => "string",
        'timeZone' => "string",
        'role'     => "array",
        'show'     => "string",
        'link'     => "string"
    ])]
    public function rules()
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'confirm'  => 'required|boolean',
            'password' => 'required|string',
            'timeZone' => 'required|integer',
            'role'     => [
                'required',
                'string',
                Rule::in([User::ROLE_NEW, User::ROLE_CLIENT, User::ROLE_ADMIN])
            ],
            'show'     => 'nullable|boolean',
            'link'     => 'nullable|string',
        ];
    }
}
