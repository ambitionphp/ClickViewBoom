<?php

namespace App\Console\Commands;

use App\Models\Text;
use Illuminate\Console\Command;

class BoomSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secrets:boom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Text::whereDate('expires_at', '<=', now())->delete();
        return 0;
    }
}
