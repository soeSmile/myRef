<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return isClient() || isAdmin();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'       => 'required|exists:users',
            'name'     => 'required|string',
            'email'    => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->request->get('id')),
            ],
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
