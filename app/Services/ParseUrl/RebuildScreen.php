<?php
declare(strict_types=1);

namespace App\Services\ParseUrl;

use App\Repository\Dto\LinkUpdateImageDto;
use App\Repository\LinkRepository;

/**
 * Class RebuildScreen
 */
final class RebuildScreen
{
    /**
     * @var int
     */
    private const CHUNK = 100;

    /**
     * @var LinkRepository
     */
    private LinkRepository $linkRepository;

    /**
     * @var MakeScreen
     */
    private MakeScreen $makeScreen;

    /**
     * @param LinkRepository $linkRepository
     * @param MakeScreen $makeScreen
     */
    public function __construct(LinkRepository $linkRepository, MakeScreen $makeScreen)
    {
        $this->linkRepository = $linkRepository;
        $this->makeScreen = $makeScreen;
    }

    /**
     * @param array $ids
     * @return void
     */
    public function reBuild(array $ids = []): void
    {
        $query = $this->linkRepository->getQuery();

        if ($ids !== []) {
            $query->whereIn('id', $ids);
        }

        $query->chunk(self::CHUNK, function ($links) {
            foreach ($links as $link) {
                $this->removeOldImage($link->img);
                $img = $this->makeScreen->makeScreen($link->url);
                $this->linkRepository->update($link->id, new LinkUpdateImageDto(['img' => $img]));
            }
        });
    }

    /**
     * @param string $image
     * @return void
     */
    private function removeOldImage(string $image): void
    {
        $dir = $this->makeScreen->getPath();
        \unlink($dir . '/' . $image);
    }
}