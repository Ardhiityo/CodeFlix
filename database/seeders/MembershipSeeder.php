<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $plan = Plan::first();

        Membership::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(7)
        ]);
    }
}
