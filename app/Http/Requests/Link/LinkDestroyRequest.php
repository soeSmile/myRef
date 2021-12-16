<?php

declare(strict_types=1);

namespace App\Http\Requests\Link;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LinkDestroyRequest
 * @package App\Http\Requests\Link
 */
class LinkDestroyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $link = Link::find($this->route('link'));
        $owner = $link && $link->isOwner();

        return isAdmin() || (isClient() && $owner);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $link = Link::find($this->route('link'));

            if (!$link->canDelete()) {
                $validator->errors()->add('id', trans('validation.not_delete_link'));
            }
        });
    }
}
