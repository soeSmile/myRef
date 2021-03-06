<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Link\LinkDestroyRequest;
use App\Http\Requests\Link\LinkStoreRequest;
use App\Http\Requests\Link\LinkUpdateRequest;
use App\Http\Resources\Link\LinkResource;
use App\Http\Resources\Link\LinkShowResource;
use App\Jobs\MakeScreenJob;
use App\Repository\Dto\LinkSearchDto;
use App\Repository\Dto\LinkStoreDto;
use App\Repository\LinkRepository;
use App\Services\ParseUrl\ParseUrl;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Log;
use Throwable;

/**
 * Class ApiLinkController
 * @package App\Http\Controllers\Api
 */
final class ApiLinkController
{
    /**
     * @var LinkRepository
     */
    private LinkRepository $link;

    /**
     * @var ParseUrl
     */
    private ParseUrl $parseUrl;

    /**
     * ApiLinkController constructor.
     * @param LinkRepository $linkRepository
     * @param ParseUrl $parseUrl
     */
    public function __construct(LinkRepository $linkRepository, ParseUrl $parseUrl)
    {
        $this->link = $linkRepository;
        $this->parseUrl = $parseUrl;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LinkResource::collection($this->link->search(new LinkSearchDto($request->all())));
    }

    /**
     * @param $id
     * @return LinkShowResource
     */
    public function show($id): LinkShowResource
    {
        return new LinkShowResource($this->link->get($id));
    }

    /**
     * @param LinkStoreRequest $request
     * @return JsonResponse
     */
    public function store(LinkStoreRequest $request): JsonResponse
    {
        $data = $this->parseUrl->parseUrl($request->url);

        try {
            $link = $this->link->storeTransaction(new LinkStoreDto(\array_merge($data, $request->all())));
            dispatch(new MakeScreenJob($link));
        } catch (Throwable $e) {
            $link = false;
            $error = 'Error! See logs!';
            Log::error($e->getMessage());
        }

        return response()->json(['success' => $link, 'errors' => $error ?? ''], $link ? 200 : 400);
    }

    /**
     * @param $id
     * @param LinkUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, LinkUpdateRequest $request): JsonResponse
    {
        try {
            $result = $this->link->updateTransaction(new LinkStoreDto($request->all()));
        } catch (Throwable $exception) {
            $result = false;
            $data['error'] = 'Error! See logs!';
            Log::error($exception->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }

    /**
     * @param $id
     * @param LinkDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy($id, LinkDestroyRequest $request): JsonResponse
    {
        try {
            $result = $this->link->destroy($id);
        } catch (Exception $e) {
            $result = false;
            Log::error($e->getMessage());
        }

        return response()->json(['success' => $result, 'errors' => ''], $result ? 200 : 400);
    }
}