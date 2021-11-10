<?php
declare(strict_types=1);

namespace App\Http\Requests\Note;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class NoteUploadAttacheRequest
 * @property mixed $id
 * @package App\Http\Requests\Note
 */
class NoteUploadAttacheRequest extends FormRequest
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
    #[ArrayShape(['id' => "string", 'file' => "string"])]
    public function rules(): array
    {
        return [
            'id'   => 'required|exists:links',
            'file' => 'required|file|max:' . Link::MAX_NOTE_FILE
        ];
    }
}
