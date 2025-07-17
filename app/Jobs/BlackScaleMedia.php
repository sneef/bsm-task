<?php

namespace App\Jobs;

use App\Services\QueueProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BlackScaleMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->service = new QueueProcessingService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->service->create();
    }
}
