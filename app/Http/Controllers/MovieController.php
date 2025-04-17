<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\Interface\MovieService;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function index()
    {
        $latestMovies = $this->movieService->getLatestMovies();
        $topRatedMovies = $this->movieService->getTopRatedMovies();

        return view('movies.index', compact('latestMovies', 'topRatedMovies'));
    }

    public function show(Movie $movie)
    {
        $streamingUrl = $this->movieService->getStreamingUrl($movie);

        return view('movies.show', compact('movie', 'streamingUrl'));
    }
}
