<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'price',
        'escrow_contract_address',
        'seats',
        'total_price',
        'status',
        'addons',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'addon_booking');
    }


}
