<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Carrental;

class CarrentalController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasRole('user')) {


        $carrentals = \App\Models\Carrental::where('user_id',auth()->id())->with(['user', 'car'])->get();
        return view('dashboard.carrentals.index', compact('carrentals'));
        }

        $carrentals = \App\Models\Carrental::with(['user', 'car'])->get();
        return view('dashboard.carrentals.index', compact('carrentals'));
    }

    public function create()
    {
                $users = \App\Models\User::all();
        $cars = \App\Models\Car::all();

        return view('dashboard.carrentals.create', compact([],'users', 'cars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'pickup_location' => 'required|string',
            'return_location' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|string|max:255',
            'return_date' => 'required|date',
            'dropoff_time' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'rental_type' => 'required|in:same-location,different-location',
            'driver_age' => 'required|in:21-24,25-29,30-64,65+',
            'extras' => 'nullable|json',
            'driver_details' => 'nullable|json'
        ]);

        $carrental = \App\Models\Carrental::create($validated);

        return redirect()->route('dashboard.carrentals.index')->with('success', 'Carrental created successfully.');
    }

    public function show($id)
    {
        $carrental = \App\Models\Carrental::findOrFail($id);
                $users = \App\Models\User::all();
        $cars = \App\Models\Car::all();

        return view('dashboard.carrentals.show', compact('carrental'));
    }

    public function edit($id)
    {
        $carrental = \App\Models\Carrental::findOrFail($id);
                $users = \App\Models\User::all();
        $cars = \App\Models\Car::all();

        return view('dashboard.carrentals.edit', compact('carrental', 'users', 'cars'));
    }

    public function update(Request $request, $id)
    {
        $carrental = \App\Models\Carrental::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'pickup_location' => 'required|string',
            'return_location' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|string|max:255',
            'return_date' => 'required|date',
            'dropoff_time' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'rental_type' => 'required|in:same-location,different-location',
            'driver_age' => 'required|in:21-24,25-29,30-64,65+',
            'extras' => 'nullable|json',
            'driver_details' => 'nullable|json'
        ]);

        $carrental->update($validated);

        return redirect()->route('dashboard.carrentals.index')->with('success', 'Carrental updated successfully.');
    }

        public function destroy($id)
    {
        $carrental = \App\Models\Carrental::findOrFail($id);
        $carrental->delete();
        return redirect()->route('dashboard.carrentals.index')->with('success', 'Carrental deleted successfully.');
    }
    public function restore($id)
    {
        $carrental = \App\Models\Carrental::withTrashed()->findOrFail($id);
        $carrental->restore();
        return redirect()->route('dashboard.carrentals.index')->with('success', 'Carrental restored successfully.');
    }
}
