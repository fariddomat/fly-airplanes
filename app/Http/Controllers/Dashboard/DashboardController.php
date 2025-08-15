<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Carrental;
use App\Models\Hotelbooking;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\Flight;
use App\Models\Rentalcompany;
use App\Models\Car;
use App\Models\Hotel;
use App\Models\Add;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('user')) {
            // User-specific statistics
            $data['total_bookings'] = $user->bookings()->count();
            $data['total_carrentals'] = $user->carrentals()->count();
            $data['total_hotelbookings'] = $user->hotelbookings()->count();
            $data['recent_bookings'] = collect([])
                ->merge($user->bookings()->latest()->take(5)->get())
                ->merge($user->carrentals()->latest()->take(5)->get())
                ->merge($user->hotelbookings()->latest()->take(5)->get())
                ->sortByDesc('created_at')
                ->take(5);
        } elseif ($user->hasRole('administrator') || $user->hasRole('superadministrator')) {
            // Administrator and Superadministrator statistics
            $data['total_airports'] = Airport::count();
            $data['total_airlines'] = Airline::count();
            $data['total_flights'] = Flight::count();
            $data['total_bookings'] = Booking::count();
            $data['total_rentalcompanies'] = Rentalcompany::count();
            $data['total_cars'] = Car::count();
            $data['total_carrentals'] = Carrental::count();
            $data['total_hotels'] = Hotel::count();
            $data['total_hotelbookings'] = Hotelbooking::count();
            $data['total_adds'] = Add::count();
            $data['recent_bookings'] = collect([])
                ->merge(Booking::latest()->take(5)->get())
                ->merge(Carrental::latest()->take(5)->get())
                ->merge(Hotelbooking::latest()->take(5)->get())
                ->sortByDesc('created_at')
                ->take(5);

            // Superadministrator-specific statistics
            if ($user->hasRole('superadministrator')) {
                $data['total_users'] = User::count();
                $data['recent_users'] = User::latest()->take(5)->get();
            }
        }

        return view('dashboard', $data);
    }
}
