<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'description',
        'price',
        'duration',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the appointments for the service.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
