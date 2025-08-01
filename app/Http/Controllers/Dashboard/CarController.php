<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Car;

class CarController extends Controller
{

    public function index()
    {
        $cars = \App\Models\Car::all();
        return view('dashboard.cars.index', compact('cars'));
    }

    public function create()
    {
                $rentalcompanies = \App\Models\Rentalcompany::all();

        return view('dashboard.cars.create', compact([],'rentalcompanies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rentalcompany_id' => 'required|exists:rentalcompanies,id',
            'name' => 'required|string|max:255',
            'year' => 'required|numeric',
            'type' => 'required|in:economy,compact,sedan,suv,luxury,van,convertible',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'price' => 'required|numeric',
            'img' => 'required|image|max:2048',
            'seats' => 'required|numeric',
            'luggage_capacity' => 'required|numeric',
            'features' => 'nullable|json',
            'rating' => 'nullable|numeric'
        ]);
                if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('public/imgs');
        }

        $car = \App\Models\Car::create($validated);
        
        return redirect()->route('dashboard.cars.index')->with('success', 'Car created successfully.');
    }

    public function show($id)
    {
        $car = \App\Models\Car::findOrFail($id);
                $rentalcompanies = \App\Models\Rentalcompany::all();

        return view('dashboard.cars.show', compact('car'));
    }

    public function edit($id)
    {
        $car = \App\Models\Car::findOrFail($id);
                $rentalcompanies = \App\Models\Rentalcompany::all();

        return view('dashboard.cars.edit', compact('car', 'rentalcompanies'));
    }

    public function update(Request $request, $id)
    {
        $car = \App\Models\Car::findOrFail($id);
        $validated = $request->validate([
            'rentalcompany_id' => 'required|exists:rentalcompanies,id',
            'name' => 'required|string|max:255',
            'year' => 'required|numeric',
            'type' => 'required|in:economy,compact,sedan,suv,luxury,van,convertible',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'price' => 'required|numeric',
            'img' => 'required|image|max:2048',
            'seats' => 'required|numeric',
            'luggage_capacity' => 'required|numeric',
            'features' => 'nullable|json',
            'rating' => 'nullable|numeric'
        ]);
                if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('public/imgs');
            if ($car->img) Storage::delete($car->img);
        }

        $car->update($validated);
        
        return redirect()->route('dashboard.cars.index')->with('success', 'Car updated successfully.');
    }

        public function destroy($id)
    {
        $car = \App\Models\Car::findOrFail($id);
        $car->delete();
        return redirect()->route('dashboard.cars.index')->with('success', 'Car deleted successfully.');
    }
    public function restore($id)
    {
        $car = \App\Models\Car::withTrashed()->findOrFail($id);
        $car->restore();
        return redirect()->route('dashboard.cars.index')->with('success', 'Car restored successfully.');
    }
}