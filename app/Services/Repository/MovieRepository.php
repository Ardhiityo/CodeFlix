<?php

namespace App\Services\Repository;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
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
            ->latest()->take(8)->get();
    }

    public function getTopRatedMovies()
    {
        return Movie::with('ratings')
            ->get()
            ->sortByDesc('average_rating')
            ->take(8);
    }

    public function getStreamingUrlByCurrentPlan()
    {
        return Auth::user()->memberships()
            ->where('active', true)
            ->where('end_date', '>=', now())
            ->first()
            ->plan->resolution;
    }

    public function getStreamingUrl(Movie $movie)
    {
        $streamingURL = $this->getStreamingUrlByCurrentPlan();
        if ($streamingURL === '720p') {
            return $movie->url_720p;
        } elseif ($streamingURL === '1080p') {
            return $movie->url_1080p;
        } elseif ($streamingURL === '2k') {
            return $movie->url_2k;
        }
    }

    public function searchMovies(string $search)
    {
        return Movie::where('title', 'like', '%' . $search . '%')->get();
    }
}
