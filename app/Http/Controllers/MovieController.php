<?php

namespace App\Http\Controllers;

use App\Services\Interface\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function index()
    {
        $latestMovies = $this->movieService->getLatestMovies();
        $topRatedMovies = $this->movieService->getTopRatedMovies();

        return view('movies.index', compact('latestMovies', 'topRatedMovies'));
    }
}
