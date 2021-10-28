<?php
declare(strict_types=1);

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

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
    #[ArrayShape(['url' => "string"])]
    public function rules(): array
    {
        return [
            'url' => 'required|url|string'
        ];
    }
}
