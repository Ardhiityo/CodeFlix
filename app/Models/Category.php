<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'category_movies', 'category_id', 'movie_id');
    }
}
