<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AbstractJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('generate-catalog');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->debug('done');
    }

    protected function debug(string $msg): void
    {
        $class = static::class;
        $msg = $msg." [{$class}]";

        logger()->info($msg);
    }
}
