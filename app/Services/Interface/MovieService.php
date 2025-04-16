<?php

namespace App\Services\Interface;

interface MovieService
{
    public function getLatestMovies();
    public function getTopRatedMovies();
}
