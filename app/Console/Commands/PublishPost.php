<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PublishPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish schedule post on scheduled date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::where('published', false)
            ->where('scheduled', '<=', now())
            ->update(['published' => true]);

        $this->info('Post status updated successfully');
    }
}
