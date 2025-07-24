<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;

class HotelController extends Controller
{

    public function index()
    {
        $hotels = \App\Models\Hotel::all();
        return view('dashboard.hotels.index', compact('hotels'));
    }

    public function create()
    {
        
        return view('dashboard.hotels.create', compact([],));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'star_rating' => 'nullable|numeric',
            'description' => 'nullable|string'
        ]);
        
        $hotel = \App\Models\Hotel::create($validated);
        
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        
        return view('dashboard.hotels.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        
        return view('dashboard.hotels.edit', compact('hotel', ));
    }

    public function update(Request $request, $id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'star_rating' => 'nullable|numeric',
            'description' => 'nullable|string'
        ]);
        
        $hotel->update($validated);
        
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel updated successfully.');
    }

        public function destroy($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        $hotel->delete();
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
    public function restore($id)
    {
        $hotel = \App\Models\Hotel::withTrashed()->findOrFail($id);
        $hotel->restore();
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel restored successfully.');
    }
}