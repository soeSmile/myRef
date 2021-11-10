<?php
declare(strict_types=1);

namespace App\Http\Requests\Note;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NoteDestroyAttacheRequest
 * @package App\Http\Requests\Note
 */
class NoteDestroyAttacheRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $link = Link::find($this->route()->id);
        $owner = $link && $link->isOwner();

        return isClient() && $owner;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
