<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Flight;

class FlightController extends Controller
{

    public function index()
    {
        $flights = \App\Models\Flight::all();
        return view('dashboard.flights.index', compact('flights'));
    }

    public function create()
    {
                $departureAirports = \App\Models\Airport::all();
        $arrivalAirports = \App\Models\Airport::all();

        return view('dashboard.flights.create', compact([],'departureAirports', 'arrivalAirports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'flight_number' => 'required|string|max:255',
            'price' => 'required|numeric',
            'available_seats' => 'required|numeric',
            'class' => 'required|in:Economy,Business,First'
        ]);

        $flight = \App\Models\Flight::create($validated);

        return redirect()->route('dashboard.flights.index')->with('success', 'Flight created successfully.');
    }

    public function show($id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
                $departureAirports = \App\Models\Airport::all();
        $arrivalAirports = \App\Models\Airport::all();

        return view('dashboard.flights.show', compact('flight'));
    }

    public function edit($id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
                $departureAirports = \App\Models\Airport::all();
        $arrivalAirports = \App\Models\Airport::all();

        return view('dashboard.flights.edit', compact('flight', 'departureAirports', 'arrivalAirports'));
    }

    public function update(Request $request, $id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
        $validated = $request->validate([
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'flight_number' => 'required|string|max:255',
            'price' => 'required|numeric',
            'available_seats' => 'required|numeric',
            'class' => 'required|in:Economy,Business,First'
        ]);

        $flight->update($validated);

        return redirect()->route('dashboard.flights.index')->with('success', 'Flight updated successfully.');
    }

        public function destroy($id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
        $flight->delete();
        return redirect()->route('dashboard.flights.index')->with('success', 'Flight deleted successfully.');
    }
    public function restore($id)
    {
        $flight = \App\Models\Flight::withTrashed()->findOrFail($id);
        $flight->restore();
        return redirect()->route('dashboard.flights.index')->with('success', 'Flight restored successfully.');
    }
}
