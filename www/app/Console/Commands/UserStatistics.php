<?php

namespace App\Console\Commands;

use App\Http\Modules\Cron\Controllers\Cron;
use Illuminate\Console\Command;

class UserStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user views';

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
     * @return mixed
     */
    public function handle()
    {
        $cron = new Cron();
        $cron->stat();
    }
}
