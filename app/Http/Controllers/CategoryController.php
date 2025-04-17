<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Interface\MovieService;

class CategoryController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function show(Category $category)
    {
        $category->load('movies');
        return view('categories.show', compact('category'));
    }
}
