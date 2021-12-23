<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Link;
use DB;
use Illuminate\Console\Command;

class SetOldLinkToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setOldLink';

    /**
     * @var string
     */
    protected $description = 'Перенос старых ссылок в новую таблицу';

    /**
     * @return void
     */
    public function handle(): void
    {
        $count = 0;

        DB::table(Link::getModel()->getTable())
            ->select('id', 'user_id')
            ->orderBy('id')
            ->chunk(10, static function ($links) {
                foreach ($links as $link) {
                    DB::table(Link::USER_LINK_TABLE)
                        ->insert([
                            'user_id' => $link->user_id,
                            'link_id' => $link->id
                        ]);
                }
            });

        echo $count;
    }
}
