<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Link\LinkResource;
use App\Repository\Dto\LinkUpdateImageDto;
use App\Repository\LinkRepository;
use App\Services\ParseUrl\RebuildScreen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiLinkAdminController
 */
final class ApiLinkAdminController
{
    /**
     * @var LinkRepository
     */
    private LinkRepository $link;

    /**
     * @var RebuildScreen
     */
    private RebuildScreen $rebuildScreen;

    /**
     * ApiLinkAdminController constructor.
     * @param LinkRepository $linkRepository
     * @param RebuildScreen $rebuildScreen
     */
    public function __construct(LinkRepository $linkRepository, RebuildScreen $rebuildScreen)
    {
        $this->link = $linkRepository;
        $this->rebuildScreen = $rebuildScreen;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function rebuildImage(Request $request): JsonResponse
    {
        $this->rebuildScreen->reBuild($request->ids);

        return response()->json([]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeImage($id): JsonResponse
    {
        $result = $this->link->update($id, new LinkUpdateImageDto(['img' => null]));

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}