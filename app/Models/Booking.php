<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time',
        'make',
        'model',
    ];

    /**
     * Check if booking slot already exists
     *
     * @param Builder $query
     * @param string $date
     * @return mixed
     */
    public function scopeHasBooking(Builder $query, string $date)
    {
        return $query->where('time', $date)->exists();
    }
}
