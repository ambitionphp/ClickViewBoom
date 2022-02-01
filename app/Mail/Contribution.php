<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contribution extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contributions.successful', [
            'contribution' => $this->contribution
        ])->subject('Thanks, you are awesome!');
    }
}
