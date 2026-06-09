<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Models\Barber;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index(): View
    {
        $appointments = Appointment::with(['user', 'service', 'barber'])
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(): View
    {
        $users = User::where('role', 'customer')->get();
        $services = Service::all();
        $barbers = Barber::all();

        return view('admin.appointments.create', compact('users', 'services', 'barbers'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        Appointment::create($request->validated());

        return Redirect::route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load(['user', 'service', 'barber']);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment): View
    {
        $users = User::where('role', 'customer')->get();
        $services = Service::all();
        $barbers = Barber::all();

        return view('admin.appointments.edit', compact('appointment', 'users', 'services', 'barbers'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        return Redirect::route('appointments.edit', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return Redirect::route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Filter appointments by date.
     */
    public function filterByDate()
    {
        $date = request('date');
        $appointments = Appointment::with(['user', 'service', 'barber'])
            ->whereDate('date', $date)
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Filter appointments by status.
     */
    public function filterByStatus()
    {
        $status = request('status');
        $appointments = Appointment::with(['user', 'service', 'barber'])
            ->where('status', $status)
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }
}
