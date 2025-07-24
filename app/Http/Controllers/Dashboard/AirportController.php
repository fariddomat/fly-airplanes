<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Airport;

class AirportController extends Controller
{

    public function index()
    {
        $airports = \App\Models\Airport::all();
        return view('dashboard.airports.index', compact('airports'));
    }

    public function create()
    {
        
        return view('dashboard.airports.create', compact([],));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'airport_code' => 'required|string|max:255',
            'airport_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255'
        ]);
        
        $airport = \App\Models\Airport::create($validated);
        
        return redirect()->route('dashboard.airports.index')->with('success', 'Airport created successfully.');
    }

    public function show($id)
    {
        $airport = \App\Models\Airport::findOrFail($id);
        
        return view('dashboard.airports.show', compact('airport'));
    }

    public function edit($id)
    {
        $airport = \App\Models\Airport::findOrFail($id);
        
        return view('dashboard.airports.edit', compact('airport', ));
    }

    public function update(Request $request, $id)
    {
        $airport = \App\Models\Airport::findOrFail($id);
        $validated = $request->validate([
            'airport_code' => 'required|string|max:255',
            'airport_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255'
        ]);
        
        $airport->update($validated);
        
        return redirect()->route('dashboard.airports.index')->with('success', 'Airport updated successfully.');
    }

        public function destroy($id)
    {
        $airport = \App\Models\Airport::findOrFail($id);
        $airport->delete();
        return redirect()->route('dashboard.airports.index')->with('success', 'Airport deleted successfully.');
    }
    public function restore($id)
    {
        $airport = \App\Models\Airport::withTrashed()->findOrFail($id);
        $airport->restore();
        return redirect()->route('dashboard.airports.index')->with('success', 'Airport restored successfully.');
    }
}