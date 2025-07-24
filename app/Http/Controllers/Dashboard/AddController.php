<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Add;

class AddController extends Controller
{

    public function index()
    {
        $adds = \App\Models\Add::all();
        return view('dashboard.adds.index', compact('adds'));
    }

    public function create()
    {
                $bookings = \App\Models\Booking::all();
        $carrentals = \App\Models\Carrental::all();
        $hotelbookings = \App\Models\Hotelbooking::all();

        return view('dashboard.adds.create', compact([],'bookings', 'carrentals', 'hotelbookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'insurance_purchased' => 'sometimes|boolean',
            'carrental_id' => 'required|exists:carrentals,id',
            'hotelbooking_id' => 'required|exists:hotelbookings,id',
            'payment_method' => 'required|string|max:255'
        ]);
        
        $add = \App\Models\Add::create($validated);
        
        return redirect()->route('dashboard.adds.index')->with('success', 'Add created successfully.');
    }

    public function show($id)
    {
        $add = \App\Models\Add::findOrFail($id);
                $bookings = \App\Models\Booking::all();
        $carrentals = \App\Models\Carrental::all();
        $hotelbookings = \App\Models\Hotelbooking::all();

        return view('dashboard.adds.show', compact('add'));
    }

    public function edit($id)
    {
        $add = \App\Models\Add::findOrFail($id);
                $bookings = \App\Models\Booking::all();
        $carrentals = \App\Models\Carrental::all();
        $hotelbookings = \App\Models\Hotelbooking::all();

        return view('dashboard.adds.edit', compact('add', 'bookings', 'carrentals', 'hotelbookings'));
    }

    public function update(Request $request, $id)
    {
        $add = \App\Models\Add::findOrFail($id);
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'insurance_purchased' => 'sometimes|boolean',
            'carrental_id' => 'required|exists:carrentals,id',
            'hotelbooking_id' => 'required|exists:hotelbookings,id',
            'payment_method' => 'required|string|max:255'
        ]);
        
        $add->update($validated);
        
        return redirect()->route('dashboard.adds.index')->with('success', 'Add updated successfully.');
    }

        public function destroy($id)
    {
        $add = \App\Models\Add::findOrFail($id);
        $add->delete();
        return redirect()->route('dashboard.adds.index')->with('success', 'Add deleted successfully.');
    }
    public function restore($id)
    {
        $add = \App\Models\Add::withTrashed()->findOrFail($id);
        $add->restore();
        return redirect()->route('dashboard.adds.index')->with('success', 'Add restored successfully.');
    }
}