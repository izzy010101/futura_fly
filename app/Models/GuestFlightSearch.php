<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestFlightSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure',
        'destination',
        'travel_date',
        'seats',
        'kids',
        'search_time',
    ];

    public $timestamps = false;
}
