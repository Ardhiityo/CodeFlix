<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function categories()
    {
        // coba tanpa table pivot
        return $this->belongsToMany(Category::class, 'category_movie', 'movie_id', 'category_id');
    }
}
