<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::insert(
            [
                [
                    'title' => 'Standard',
                    'price' => 89999,
                    'resolution' => '1080p',
                    'max_devices' => 2,
                    'duration' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Premium',
                    'price' => 129999,
                    'resolution' => '2k',
                    'max_devices' => 4,
                    'duration' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
