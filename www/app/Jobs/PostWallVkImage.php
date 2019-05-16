<?php

namespace App\Jobs;

use Exception;
use App\Http\Modules\Cron\Controllers\Vk;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PostWallVkImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_pictureId;

    public $tries = 1;

    /**
     * Create a new job instance.
     * @param int $pictureId
     * @return void
     */
    public function __construct(int $pictureId)
    {
        $this->_pictureId = $pictureId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Vk::posting();
//        info($this->_pictureId);
    }

    public function failed(Exception $exception)
    {
        info('12323');
    }
}
