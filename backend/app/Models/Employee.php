<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'avatar_url',
    ];

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
}
