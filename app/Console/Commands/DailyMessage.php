<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send daily messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo now()->format('m/d/Y H:ia'). ": This is my first message\n";
    }
}
