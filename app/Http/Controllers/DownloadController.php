<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Link;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class DownloadController
 */
class DownloadController
{
    /**
     * @param $id
     * @return StreamedResponse
     */
    public function getAttachNote($id): StreamedResponse
    {
        $link = Link::findOrFail($id);

        if (!$link->file) {
            abort(404);
        }

        return \Storage::download('link/' . $link->id . '/' . $link->file);
    }
}