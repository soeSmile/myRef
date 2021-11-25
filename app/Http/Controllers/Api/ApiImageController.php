<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Image\ImageDestroyRequest;
use App\Http\Requests\Image\ImageUpdateRequest;
use App\Repository\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class ApiImageController
 */
final class ApiImageController
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
     * @param $id
     * @param ImageUpdateRequest $request
     */
    public function update($id, ImageUpdateRequest $request)
    {
    }

    /**
     * @param $id
     * @param ImageDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy($id, ImageDestroyRequest $request): JsonResponse
    {
        try {
            $result = $this->linkRepository->destroyImage($id);
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }
}