<?php

namespace App\Services\Interface;

use App\Models\Movie;

interface MovieService
{
    public function getLatestMovies();
    public function getTopRatedMovies();
    public function getStreamingUrlByCurrentPlan();
    public function getStreamingUrl(Movie $movie);
}
