<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Link\LinkStoreRequest;
use App\Http\Resources\Link\LinkResource;
use App\Repository\Dto\LinkStoreDto;
use App\Repository\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiLinkController
 * @package App\Http\Controllers\Api
 */
class ApiLinkController
{
    /**
     * @var LinkRepository
     */
    private LinkRepository $link;

    /**
     * ApiLinkController constructor.
     * @param LinkRepository $linkRepository
     */
    public function __construct(LinkRepository $linkRepository)
    {
        $this->link = $linkRepository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LinkResource::collection($this->link->all($request->all()));
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
        $this->link->store(new LinkStoreDto($request->all()));

        return response()->json(['success' => true]);
    }
}