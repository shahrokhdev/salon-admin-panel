<?php

namespace App\Http\Controllers;

use App\Models\AvailabilitySlot;
use App\Models\Barber;
use App\Http\Requests\StoreAvailabilitySlotRequest;
use App\Http\Requests\UpdateAvailabilitySlotRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AvailabilitySlotController extends Controller
{
    /**
     * Display a listing of availability slots.
     */
    public function index(): View
    {
        $slots = AvailabilitySlot::with('barber.user')->paginate(10);
        return view('admin.availability-slots.index', compact('slots'));
    }

    /**
     * Show the form for creating a new availability slot.
     */
    public function create(): View
    {
        $barbers = Barber::all();
        return view('admin.availability-slots.create', compact('barbers'));
    }

    /**
     * Store a newly created availability slot in storage.
     */
    public function store(StoreAvailabilitySlotRequest $request): RedirectResponse
    {
        AvailabilitySlot::create($request->validated());

        return Redirect::route('availability-slots.index')
            ->with('success', 'Availability slot created successfully.');
    }

    /**
     * Show the form for editing the specified availability slot.
     */
    public function edit(AvailabilitySlot $availabilitySlot): View
    {
        $barbers = Barber::all();
        return view('admin.availability-slots.edit', compact('availabilitySlot', 'barbers'));
    }

    /**
     * Update the specified availability slot in storage.
     */
    public function update(UpdateAvailabilitySlotRequest $request, AvailabilitySlot $availabilitySlot): RedirectResponse
    {
        $availabilitySlot->update($request->validated());

        return Redirect::route('availability-slots.edit', $availabilitySlot)
            ->with('success', 'Availability slot updated successfully.');
    }

    /**
     * Remove the specified availability slot from storage.
     */
    public function destroy(AvailabilitySlot $availabilitySlot): RedirectResponse
    {
        $availabilitySlot->delete();

        return Redirect::route('availability-slots.index')
            ->with('success', 'Availability slot deleted successfully.');
    }

    /**
     * Mark availability slot as booked.
     */
    public function markAsBooked(AvailabilitySlot $availabilitySlot): RedirectResponse
    {
        $availabilitySlot->update(['is_booked' => true]);

        return Redirect::back()
            ->with('success', 'Availability slot marked as booked.');
    }

    /**
     * Mark availability slot as available.
     */
    public function markAsAvailable(AvailabilitySlot $availabilitySlot): RedirectResponse
    {
        $availabilitySlot->update(['is_booked' => false]);

        return Redirect::back()
            ->with('success', 'Availability slot marked as available.');
    }
}
