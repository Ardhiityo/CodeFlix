<?php

namespace App\View\Components;

use App\Services\Interface\CategoryService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class CategoryNav extends Component
{
    public $categories;
    /**
     * Create a new component instance.
     */
    public function __construct(private CategoryService $categoryService)
    {
        $this->categories = Cache::remember('categories', 3600, function () {
            return $this->categoryService->getAllCategories()->chunk(3);
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-nav');
    }
}
