<?php
declare(strict_types=1);

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LinkStoreRequest
 * @property string $url
 * @package App\Http\Requests\Link
 */
class LinkStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return isClient();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'url' => 'required|url|string'
        ];
    }
}
