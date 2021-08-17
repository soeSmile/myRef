<?php

namespace App\Mail;

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
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.showRef');
    }
}
