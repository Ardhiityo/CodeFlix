<?php

namespace App\Services\Repository;

use App\Models\Category;
use App\Services\Interface\CategoryService;

class CategoryRepository implements CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllCategories()
    {
        return Category::select('title', 'slug', 'id')
            ->get();
    }
}
