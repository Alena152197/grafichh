<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'start_time',
        'end_time',
        'duration_hours',
        'color',
    ];

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
}
