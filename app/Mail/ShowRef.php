<?php

namespace App\Mail;

use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ShowRef
 */
class ShowRef extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Link
     */
    public Link $link;

    /**
     * @return void
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.showRef');
    }
}
