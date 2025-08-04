<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotelbooking;

class HotelbookingController extends Controller
{

    public function index()
    {
        $hotelbookings = \App\Models\Hotelbooking::with(['user', 'hotel'])->get();
        return view('dashboard.hotelbookings.index', compact('hotelbookings'));
    }

    public function create()
    {
                $users = \App\Models\User::all();
        $hotels = \App\Models\Hotel::all();

        return view('dashboard.hotelbookings.create', compact([],'users', 'hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'room_type' => 'nullable|string|max:255',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending'
        ]);

        $hotelbooking = \App\Models\Hotelbooking::create($validated);

        return redirect()->route('dashboard.hotelbookings.index')->with('success', 'Hotelbooking created successfully.');
    }

    public function show($id)
    {
        $hotelbooking = \App\Models\Hotelbooking::findOrFail($id);
                $users = \App\Models\User::all();
        $hotels = \App\Models\Hotel::all();

        return view('dashboard.hotelbookings.show', compact('hotelbooking'));
    }

    public function edit($id)
    {
        $hotelbooking = \App\Models\Hotelbooking::findOrFail($id);
                $users = \App\Models\User::all();
        $hotels = \App\Models\Hotel::all();

        return view('dashboard.hotelbookings.edit', compact('hotelbooking', 'users', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $hotelbooking = \App\Models\Hotelbooking::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'room_type' => 'nullable|string|max:255',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending'
        ]);

        $hotelbooking->update($validated);

        return redirect()->route('dashboard.hotelbookings.index')->with('success', 'Hotelbooking updated successfully.');
    }

        public function destroy($id)
    {
        $hotelbooking = \App\Models\Hotelbooking::findOrFail($id);
        $hotelbooking->delete();
        return redirect()->route('dashboard.hotelbookings.index')->with('success', 'Hotelbooking deleted successfully.');
    }
    public function restore($id)
    {
        $hotelbooking = \App\Models\Hotelbooking::withTrashed()->findOrFail($id);
        $hotelbooking->restore();
        return redirect()->route('dashboard.hotelbookings.index')->with('success', 'Hotelbooking restored successfully.');
    }
}
