<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::get();
        $categories = Category::pluck('id');

        foreach ($movies as $index => $movie) {
            $movie->categories()->attach(
                $categories[$index]
            );
            if ($index === count($categories) - 1) {
                break;
            }
        }
    }
}
