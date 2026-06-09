<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\User;
use App\Http\Requests\StoreBarberRequest;
use App\Http\Requests\UpdateBarberRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class BarberController extends Controller
{
    /**
     * Display a listing of barbers.
     */
    public function index(): View
    {
        $barbers = Barber::with('user')->paginate(10);
        return view('admin.barbers.index', compact('barbers'));
    }

    /**
     * Show the form for creating a new barber.
     */
    public function create(): View
    {
        $users = User::where('role', 'barber')->get();
        return view('admin.barbers.create', compact('users'));
    }

    /**
     * Store a newly created barber in storage.
     */
    public function store(StoreBarberRequest $request): RedirectResponse
    {
        $data = $request->only(['user_id', 'bio', 'rating']);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('barbers', 'public');
        }

        Barber::create($data);

        return Redirect::route('barbers.index')
            ->with('success', 'Barber created successfully.');
    }

    /**
     * Show the form for editing the specified barber.
     */
    public function edit(Barber $barber): View
    {
        $users = User::where('role', 'barber')->get();
        return view('admin.barbers.edit', compact('barber', 'users'));
    }

    /**
     * Update the specified barber in storage.
     */
    public function update(UpdateBarberRequest $request, Barber $barber): RedirectResponse
    {
        $data = $request->only(['user_id', 'bio', 'rating']);

        if ($request->hasFile('profile_image')) {
            if ($barber->profile_image) {
                Storage::disk('public')->delete($barber->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('barbers', 'public');
        }

        $barber->update($data);

        return Redirect::route('barbers.edit', $barber)
            ->with('success', 'Barber updated successfully.');
    }

    /**
     * Remove the specified barber from storage.
     */
    public function destroy(Barber $barber): RedirectResponse
    {
        if ($barber->profile_image) {
            Storage::disk('public')->delete($barber->profile_image);
        }
        $barber->delete();

        return Redirect::route('barbers.index')
            ->with('success', 'Barber deleted successfully.');
    }
}
