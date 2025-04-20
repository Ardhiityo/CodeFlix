<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckMembershipStatus;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class CheckMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-membership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update membership status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Bus::batch([
            new CheckMembershipStatus()
        ])
            ->then(function ($batch) {
                // All jobs completed successfully
                Log::info('All membership status checks completed successfully.');
            })->catch(function ($batch, $e) {
                // First batch job failure detected
                Log::info('Batch job failed: ' . $e->getMessage());
            })->finally(function ($batch) {
                // Cleanup or final actions
                Log::info('Membership status check process finished.');
            })
            ->dispatch();
    }
}
