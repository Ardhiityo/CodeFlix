<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PlanSeeder::class,
            MembershipSeeder::class,
            CategorySeeder::class,
            MovieSeeder::class,
            RatingSeeder::class,
            CategoryMovieSeeder::class,
        ]);
    }
}
