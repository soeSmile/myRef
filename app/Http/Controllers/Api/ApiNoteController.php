<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Note\NoteDestroyAttacheRequest;
use App\Http\Requests\Note\NoteStoreRequest;
use App\Http\Requests\Note\NoteUpdateRequest;
use App\Http\Requests\Note\NoteUploadAttacheRequest;
use App\Repository\Dto\LinkUpdateDto;
use App\Repository\Dto\NoteStoreDto;
use App\Repository\Dto\NoteUpdateDto;
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
        if ($request->file('file')) {
            $fileData = [
                'path' => $request->file('file')->store('temp'),
                'file' => $request->file('file')->hashName(),
            ];
        }

        $data = \array_merge($request->all(), $fileData ?? []);

        try {
            $link = $this->linkRepository->storeTransaction(new NoteStoreDto($data));
        } catch (Throwable $e) {
            $link = false;
            $error = 'Error! See logs!';
            Log::error($e->getMessage());
        }

        return response()->json(['success' => $link, 'errors' => $error ?? ''], $link ? 200 : 400);
    }

    /**
     * @param $id
     * @param NoteUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, NoteUpdateRequest $request): JsonResponse
    {
        try {
            $result = $this->linkRepository->updateTransaction(new NoteUpdateDto($request->all()));
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }

    /**
     * @param $id
     * @param NoteUploadAttacheRequest $request
     * @return JsonResponse
     */
    public function uploadAttache($id, NoteUploadAttacheRequest $request): JsonResponse
    {
        try {
            $request->file('file')->store('link/' . $id);
            $file = $request->file('file')->hashName();
            $result = $this->linkRepository->update($id, new LinkUpdateDto(['file' => $file]));
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }

    /**
     * @param $id
     * @param NoteDestroyAttacheRequest $request
     * @return JsonResponse
     */
    public function destroyAttache($id, NoteDestroyAttacheRequest $request): JsonResponse
    {
        try {
            $result = $this->linkRepository->destroyAttache($id);
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }
}