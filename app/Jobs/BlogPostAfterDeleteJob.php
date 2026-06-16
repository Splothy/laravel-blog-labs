<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BlogPostAfterDeleteJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $blogPostId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->warning("Видалено запис в блозі [{$this->blogPostId}]");
    }
}
