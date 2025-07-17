<?php

namespace App\Jobs;

use App\Services\QueueProcessingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BlackScaleMedia implements ShouldQueue
{
    use Queueable;

    protected $service;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        info('construct');
        $this->service = new QueueProcessingService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('handle queue');

        $this->service->create();
    }
}
