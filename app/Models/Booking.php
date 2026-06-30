<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'booking_date',
        'booking_time',
        'service',
        'name',
        'phone',
        'email',
        'notes',
        'address',
        'user_id',
    ];

    // Define a relação com o utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}