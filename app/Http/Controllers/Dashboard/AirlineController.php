<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Airline;

class AirlineController extends Controller
{

    public function index()
    {
        $airlines = \App\Models\Airline::all();
        return view('dashboard.airlines.index', compact('airlines'));
    }

    public function create()
    {
        
        return view('dashboard.airlines.create', compact([],));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'airline_name' => 'required|string|max:255',
            'airline_code' => 'required|string|max:255'
        ]);
        
        $airline = \App\Models\Airline::create($validated);
        
        return redirect()->route('dashboard.airlines.index')->with('success', 'Airline created successfully.');
    }

    public function show($id)
    {
        $airline = \App\Models\Airline::findOrFail($id);
        
        return view('dashboard.airlines.show', compact('airline'));
    }

    public function edit($id)
    {
        $airline = \App\Models\Airline::findOrFail($id);
        
        return view('dashboard.airlines.edit', compact('airline', ));
    }

    public function update(Request $request, $id)
    {
        $airline = \App\Models\Airline::findOrFail($id);
        $validated = $request->validate([
            'airline_name' => 'required|string|max:255',
            'airline_code' => 'required|string|max:255'
        ]);
        
        $airline->update($validated);
        
        return redirect()->route('dashboard.airlines.index')->with('success', 'Airline updated successfully.');
    }

        public function destroy($id)
    {
        $airline = \App\Models\Airline::findOrFail($id);
        $airline->delete();
        return redirect()->route('dashboard.airlines.index')->with('success', 'Airline deleted successfully.');
    }
    public function restore($id)
    {
        $airline = \App\Models\Airline::withTrashed()->findOrFail($id);
        $airline->restore();
        return redirect()->route('dashboard.airlines.index')->with('success', 'Airline restored successfully.');
    }
}