<?php
declare(strict_types=1);

namespace App\Http\Requests\Note;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class NoteUpdateRequest
 * @package App\Http\Requests\Note
 */
class NoteUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $link = Link::find($this->get('id'));
        $owner = $link && $link->isOwner();

        return isClient() && $owner;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'title' => "string", 'file' => "string"])]
    public function rules(): array
    {
        return [
            'id'    => 'required|exists:links',
            'title' => 'required|string',
            'file'  => 'file|max:' . Link::MAX_NOTE_FILE . '|nullable'
        ];
    }
}
