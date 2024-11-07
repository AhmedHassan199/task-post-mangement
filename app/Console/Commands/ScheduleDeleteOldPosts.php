<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldSoftDeletedPosts;
use Illuminate\Console\Command;

class ScheduleDeleteOldPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-delete-old-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DeleteOldSoftDeletedPosts::dispatch();
        $this->info('Job dispatched to delete old soft-deleted posts.');    }
}
