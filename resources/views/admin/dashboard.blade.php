@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="fas fa-chart-line"></i> Welcome to Admin Dashboard
    </h1>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Total Customers</div>
                <div class="card-value">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-info">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-title">Total Barbers</div>
                <div class="card-value">{{ $totalBarbers }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-warning">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="card-title">Total Services</div>
                <div class="card-value">{{ $totalServices }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-success">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-title">Total Appointments</div>
                <div class="card-value">{{ $totalAppointments }}</div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-title">Today's Appointments</div>
                <div class="card-value">{{ $todayAppointments }}</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-info">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="card-title">This Month</div>
                <div class="card-value">{{ $appointmentsThisMonth }}</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon text-secondary">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="card-title">Last Month</div>
                <div class="card-value">{{ $appointmentsLastMonth }}</div>
            </div>
        </div>
    </div>

    <!-- Appointments by Status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">Appointments by Status</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-warning me-2" style="width: 20px; height: 20px;"></span>
                            <span>Pending: <strong>{{ $appointmentsByStatus->get('pending', 0) }}</strong></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-info me-2" style="width: 20px; height: 20px;"></span>
                            <span>Confirmed: <strong>{{ $appointmentsByStatus->get('confirmed', 0) }}</strong></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-success me-2" style="width: 20px; height: 20px;"></span>
                            <span>Completed: <strong>{{ $appointmentsByStatus->get('completed', 0) }}</strong></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-danger me-2" style="width: 20px; height: 20px;"></span>
                            <span>Cancelled: <strong>{{ $appointmentsByStatus->get('cancelled', 0) }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                    <a href="{{ route('barbers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Barber
                    </a>
                    <a href="{{ route('services.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Service
                    </a>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <h5 class="mb-3">
                    <i class="fas fa-list"></i> Recent Reservations
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Barber</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->user->name }}</td>
                                    <td>{{ $appointment->service->title }}</td>
                                    <td>{{ $appointment->barber?->user->name ?? 'N/A' }}</td>
                                    <td>{{ $appointment->date->format('M d, Y') }} at {{ $appointment->time }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->getStatusColorAttribute() }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">
                                        <i class="fas fa-inbox"></i> No appointments yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
