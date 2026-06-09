<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barber;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);

        // Create barber users
        $barberUsers = User::factory()
            ->barber()
            ->count(5)
            ->create();

        // Create customer users
        User::factory()
            ->customer()
            ->count(20)
            ->create();

        // Create barbers from barber users
        foreach ($barberUsers as $user) {
            Barber::factory()
                ->for($user)
                ->create();
        }

        // Create services
        $services = Service::factory()
            ->count(10)
            ->create();

        // Create appointments
        Appointment::factory()
            ->count(30)
            ->create();

        // Create availability slots
        AvailabilitySlot::factory()
            ->count(50)
            ->create();
    }
}
