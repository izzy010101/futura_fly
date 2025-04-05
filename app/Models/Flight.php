<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
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


    protected static function booted()
    {
        static::saving(function ($flight) {
            if ($flight->departure_time && $flight->arrival_time) {
                $departure = Carbon::parse($flight->departure_time);
                $arrival = Carbon::parse($flight->arrival_time);
                $duration = $departure->diff($arrival);

                $flight->flight_duration = $duration->format('%hh %Im');
            }
        });
    }

}
