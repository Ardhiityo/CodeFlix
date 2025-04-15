<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct() {}

    public function index()
    {
        return view('movies.index');
    }
}
