<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteOldRecords extends Command
{
    protected $signature = 'delete:oldrecords';

    protected $description = 'Delete records older than 7 days';

    public function handle()
    {
        DB::table('ch_messages')
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->delete();

        $this->info('Old records deleted successfully');
    }
}