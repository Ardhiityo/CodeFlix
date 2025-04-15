<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
