<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'bio',
        'profile_image',
        'rating',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the barber.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the availability slots for the barber.
     */
    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    /**
     * Get the appointments for the barber.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
