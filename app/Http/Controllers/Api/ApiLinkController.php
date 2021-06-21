<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Link\LinkStoreRequest;
use App\Http\Resources\Link\LinkResource;
use App\Repository\Dto\LinkSearchDto;
use App\Repository\Dto\LinkStoreDto;
use App\Repository\LinkRepository;
use App\Services\ParseUrl\ParseUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    private ParseUrl $paseUrl;

    /**
     * ApiLinkController constructor.
     * @param LinkRepository $linkRepository
     * @param ParseUrl $parseUrl
     */
    public function __construct(LinkRepository $linkRepository, ParseUrl $parseUrl)
    {
        $this->link = $linkRepository;
        $this->paseUrl = $parseUrl;
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
     * @return LinkResource
     */
    public function show($id): LinkResource
    {
        return new LinkResource($this->link->get($id));
    }

    /**
     * @param LinkStoreRequest $request
     * @return JsonResponse
     */
    public function store(LinkStoreRequest $request): JsonResponse
    {
        $data = $this->paseUrl->parseUrl($request->url);
        $result = false;

        if (!isset($data['error'])) {
            $result = (bool)$this->link->store(new LinkStoreDto(\array_merge($data, $request->all())));
        }

        return response()->json(['success' => $result, 'errors' => $data['error'] ?? ''], $result ? 200 : 400);
    }
}