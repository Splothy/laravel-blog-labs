<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Support\Collection;

class GeneratePricesFileChunkJob extends AbstractJob
{
    public function __construct(
        private Collection $chunk,
        private int $fileNum,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->debug("done file {$this->fileNum}: ".$this->chunk->implode(','));
    }
}
