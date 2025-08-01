<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = \App\Models\Booking::all();
        return view('dashboard.bookings.index', compact('bookings'));
    }

    public function create()
    {
                $users = \App\Models\User::all();
        $flights = \App\Models\Flight::all();
        $returnFlights = \App\Models\ReturnFlight::all();

        return view('dashboard.bookings.create', compact([],'users', 'flights', 'returnFlights'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'flight_id' => 'required|exists:flights,id',
            'return_flight_id' => 'nullable|exists:return_flights,id',
            'num_passengers' => 'required|numeric',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'trip_type' => 'required|in:oneway,roundtrip,multicity',
            'passenger_details' => 'required|string'
        ]);
        
        $booking = \App\Models\Booking::create($validated);
        
        return redirect()->route('dashboard.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
                $users = \App\Models\User::all();
        $flights = \App\Models\Flight::all();
        $returnFlights = \App\Models\ReturnFlight::all();

        return view('dashboard.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
                $users = \App\Models\User::all();
        $flights = \App\Models\Flight::all();
        $returnFlights = \App\Models\ReturnFlight::all();

        return view('dashboard.bookings.edit', compact('booking', 'users', 'flights', 'returnFlights'));
    }

    public function update(Request $request, $id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'flight_id' => 'required|exists:flights,id',
            'return_flight_id' => 'nullable|exists:return_flights,id',
            'num_passengers' => 'required|numeric',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'trip_type' => 'required|in:oneway,roundtrip,multicity',
            'passenger_details' => 'required|string'
        ]);
        
        $booking->update($validated);
        
        return redirect()->route('dashboard.bookings.index')->with('success', 'Booking updated successfully.');
    }

        public function destroy($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('dashboard.bookings.index')->with('success', 'Booking deleted successfully.');
    }
    public function restore($id)
    {
        $booking = \App\Models\Booking::withTrashed()->findOrFail($id);
        $booking->restore();
        return redirect()->route('dashboard.bookings.index')->with('success', 'Booking restored successfully.');
    }
}