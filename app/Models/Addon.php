<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = ['name', 'description', 'price', 'unit'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }
}
