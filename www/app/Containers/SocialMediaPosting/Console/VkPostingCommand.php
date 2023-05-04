<?php

namespace App\Containers\SocialMediaPosting\Console;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\SocialMediaPosting\Services\BroadcastPostingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class VkPostingCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'vk:posting';

    /**
     * @var string
     */
    protected $description = 'Постинг изображения в ВК';

    private readonly BroadcastPostingService $service;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = app(BroadcastPostingService::class);
    }

    /**
     * @throws NotFoundPicture
     * @throws NotFoundPictureIdForPostingException
     * @throws RepositoryException
     */
    public function handle(): void
    {
        try {
            $this->service->broadcast();
            $this->info('Success');
        } catch (Throwable $e) {
            Log::error($e);
            $this->error($e->getMessage());
        }
    }
}
