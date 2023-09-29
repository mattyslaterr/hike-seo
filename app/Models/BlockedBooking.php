<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'slot'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
    ];
}
