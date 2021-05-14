<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserStoreRequest
 * @package App\Http\Requests\User
 */
class UserStoreRequest extends FormRequest
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
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'confirm'  => 'required|boolean',
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
