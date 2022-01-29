<?php

namespace App\Jobs;

use App\Models\Text;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BoomText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $textId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($textId)
    {
        $this->textId = $textId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $text = Text::find($this->textId);
        if( $text ) {
            $text->delete();
        }
    }
}
