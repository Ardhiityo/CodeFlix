<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\Interface\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $keyword = $request->query('search');
            $movies = $this->movieService->searchMovies($keyword);

            return view('movies.search', compact('movies',  'keyword'));
        } else {
            $latestMovies = $this->movieService->getLatestMovies();
            $topRatedMovies = $this->movieService->getTopRatedMovies();

            return view('movies.index', compact('latestMovies', 'topRatedMovies'));
        }
    }

    public function show(Movie $movie)
    {
        $streamingUrl = $this->movieService->getStreamingUrl($movie);

        return view('movies.show', compact('movie', 'streamingUrl'));
    }

    public function all(Request $request)
    {
        $movies = Movie::latest()->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.movie-list', compact('movies'))->render(),
                'next_page' => $movies->hasMorePages()
            ]);
        }

        return view('movies.all', compact('movies'));
    }
}
