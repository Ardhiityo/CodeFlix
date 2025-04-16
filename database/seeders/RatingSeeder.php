<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();
        $user = User::first();

        $faker = \Faker\Factory::create();

        foreach ($movies as $movie) {
            $movie->ratings()->create([
                'user_id' => $user->id,
                'rating' => $faker->randomFloat(1, 0, 5),
            ]);
        }
    }
}
