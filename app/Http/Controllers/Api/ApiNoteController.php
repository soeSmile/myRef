<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Note\NoteStoreRequest;
use App\Repository\Dto\NoteStoreDto;
use App\Repository\LinkRepository;
use Illuminate\Http\JsonResponse;
use Log;
use Throwable;

/**
 * Class ApiNoteController
 */
final class ApiNoteController
{
    /**
     * @var LinkRepository
     */
    private LinkRepository $linkRepository;

    /**
     * @param LinkRepository $linkRepository
     */
    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    /**
     * @param NoteStoreRequest $request
     * @return JsonResponse
     */
    public function store(NoteStoreRequest $request): JsonResponse
    {
        try {
            $link = $this->linkRepository->storeTransaction(new NoteStoreDto($request->all()));
        } catch (Throwable $e) {
            $link = false;
            $error = 'Error! See logs!';
            Log::error($e->getMessage());
        }

        return response()->json(['success' => $link, 'errors' => $error ?? ''], $link ? 200 : 400);
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}