<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $appends = ['average_rating'];

    protected $with = ['categories'];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->count() >= 1 ? $this->ratings()->avg('rating') : 0
        );
    }

    public function duration(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $hours = $value / 60;

                if ($hours >= 1) {
                    $totalMinutes = (int) $value;
                    // Menghitung jumlah jam
                    $hours = floor($totalMinutes / 60);
                    // Sisa menit setelah dikonversi ke jam
                    $minutes = $totalMinutes % 60;

                    return sprintf('%dh %dm', $hours, $minutes);
                } else {
                    return $value . 'm';
                }
            }
        );
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movies', 'movie_id', 'category_id');
    }
}
