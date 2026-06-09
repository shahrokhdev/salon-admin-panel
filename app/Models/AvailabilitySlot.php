<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'barber_id',
        'date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    protected $casts = [
        'date' => 'date',
        'is_booked' => 'boolean',
    ];

    /**
     * Get the barber that owns the availability slot.
     */
    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }
}
