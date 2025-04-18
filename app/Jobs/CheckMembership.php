<?php

namespace App\Jobs;

use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMembership implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Membership $membership): void
    {
        Membership::where('end_date', '<', now())
            ->update(['active' => false]);
    }
}
