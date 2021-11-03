<?php
declare(strict_types=1);

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class NoteStoreRequest
 * @property string $url
 * @package App\Http\Requests\Link
 */
class NoteStoreRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'file' => "string"])]
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'file'  => 'file|max:2048|nullable'
        ];
    }
}
