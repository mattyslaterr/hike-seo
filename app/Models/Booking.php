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
        'date',
        'slot',
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

    /**
     * Find booking by user email
     *
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeWhereUserEmail(Builder $query, string $email)
    {
        return $query->whereHas('user', function($q) use($email) {
            return $q->where('email', $email);
        });
    }

    /**
     * User relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
