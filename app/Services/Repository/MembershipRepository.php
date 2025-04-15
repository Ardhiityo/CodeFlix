<?php

namespace App\Services\Repository;

use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use App\Services\Interface\MembershipService;

class MembershipRepository implements MembershipService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createMembership(int $planId)
    {
        $user = Auth::user();

        return Membership::create([
            'user_id' => $user->id,
            'plan_id' => $planId,
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30)
        ]);
    }
}
