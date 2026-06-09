<?php

namespace Database\Factories;

use App\Models\Barber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AvailabilitySlot>
 */
class AvailabilitySlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barber_id' => Barber::factory(),
            'date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'is_booked' => fake()->boolean(),
        ];
    }
}
