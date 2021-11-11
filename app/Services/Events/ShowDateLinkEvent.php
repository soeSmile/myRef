<?php
declare(strict_types=1);

namespace App\Services\Events;

use App\Mail\ShowRef;
use App\Models\Event;
use App\Models\Link;
use Carbon\Carbon;
use Mail;

/**
 * Class ShowDateLinkEvent
 */
final class ShowDateLinkEvent extends AbstractEvent
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        foreach ($this->getEvents(Event::EVENT_DATE) as $event) {
            if (Carbon::now()->gte($event->date)) {
                $link = Link::find($event->item_id);

                if ($link) {
                    Mail::to($link->user)->queue(new ShowRef($link));
                }
                $this->removeEvent($event->id);
            }
        }
    }
}