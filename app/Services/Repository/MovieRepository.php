<?php

namespace App\Services\Repository;

use App\Models\Movie;
use App\Services\Interface\MovieService;
use Illuminate\Database\Eloquent\Builder;

class MovieRepository implements MovieService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getLatestMovies()
    {
        return Movie::withAvg('ratings', 'rating')
            ->latest()->take(3)->get();
    }

    public function getTopRatedMovies()
    {
        return Movie::with('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(8)
            ->get();
    }
}
