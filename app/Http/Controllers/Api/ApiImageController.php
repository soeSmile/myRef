<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Image\ImageDestroyRequest;
use App\Http\Requests\Image\ImageUpdateRequest;
use App\Repository\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;
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
     * @param ImageUpdateRequest $request
     * @return JsonResponse
     */
    public function store(ImageUpdateRequest $request): JsonResponse
    {
        $image = $request->file('image');
        $fileName = Uuid::uuid6()->toString() . '.webp';

        $imgFile = Image::make($image->getRealPath());
        $dir = storage_path('app/public/screen');

        $imgFile->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dir . '/' . $fileName, 100, 'webp');

        try {
            $result = $this->linkRepository->updateImage($request->id, $fileName);
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['data' => $fileName, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
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