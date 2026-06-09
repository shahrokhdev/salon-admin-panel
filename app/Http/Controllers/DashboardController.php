<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barber;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $totalUsers = User::where('role', 'customer')->count();
        $totalBarbers = Barber::count();
        $totalServices = Service::count();
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('date', Carbon::today())->count();

        // Monthly statistics
        $appointmentsThisMonth = Appointment::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        $appointmentsLastMonth = Appointment::whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
            ->count();

        // Recent reservations
        $recentAppointments = Appointment::with(['user', 'service', 'barber'])
            ->latest()
            ->limit(5)
            ->get();

        // Appointment status breakdown
        $appointmentsByStatus = Appointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalBarbers' => $totalBarbers,
            'totalServices' => $totalServices,
            'totalAppointments' => $totalAppointments,
            'todayAppointments' => $todayAppointments,
            'appointmentsThisMonth' => $appointmentsThisMonth,
            'appointmentsLastMonth' => $appointmentsLastMonth,
            'recentAppointments' => $recentAppointments,
            'appointmentsByStatus' => $appointmentsByStatus,
        ]);
    }
}
