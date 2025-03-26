<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline',
        'flight_number',
        'departure',
        'destination',
        'departure_time',
        'arrival_time',
        'price',
        'seats_available',
        'last_minute',
        'first_minute',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
