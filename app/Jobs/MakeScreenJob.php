<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Services\ParseUrl\MakeScreen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class MakeScreen
 */
class MakeScreenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private Model $link;

    /**
     * @var int
     */
    private const DELAY = 30;

    /**
     * @param Model $link
     */
    public function __construct(Model $link)
    {
        $this->link = $link;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $screen = new MakeScreen();

        $screen->request($this->link->url);
        sleep(self::DELAY);
        $this->link->img = $screen->makeScreen($this->link->url);
        $this->link->save();
    }
}
