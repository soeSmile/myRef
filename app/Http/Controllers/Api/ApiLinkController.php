<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Repository\LinkRepository;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        return $this->link->all($request->all());
    }
}