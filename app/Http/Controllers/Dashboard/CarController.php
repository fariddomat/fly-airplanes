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
            'car_model' => 'nullable|string|max:255',
            'car_make' => 'nullable|string|max:255',
            'car_year' => 'required|numeric'
        ]);
        
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
            'car_model' => 'nullable|string|max:255',
            'car_make' => 'nullable|string|max:255',
            'car_year' => 'required|numeric'
        ]);
        
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