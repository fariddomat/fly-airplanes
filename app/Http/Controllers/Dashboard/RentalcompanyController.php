<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rentalcompany;

class RentalcompanyController extends Controller
{

    public function index()
    {
        $rentalcompanies = \App\Models\Rentalcompany::all();
        return view('dashboard.rentalcompanies.index', compact('rentalcompanies'));
    }

    public function create()
    {
        
        return view('dashboard.rentalcompanies.create', compact([],));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'logo' => 'required|string|max:255'
        ]);
        
        $rentalcompany = \App\Models\Rentalcompany::create($validated);
        
        return redirect()->route('dashboard.rentalcompanies.index')->with('success', 'Rentalcompany created successfully.');
    }

    public function show($id)
    {
        $rentalcompany = \App\Models\Rentalcompany::findOrFail($id);
        
        return view('dashboard.rentalcompanies.show', compact('rentalcompany'));
    }

    public function edit($id)
    {
        $rentalcompany = \App\Models\Rentalcompany::findOrFail($id);
        
        return view('dashboard.rentalcompanies.edit', compact('rentalcompany', ));
    }

    public function update(Request $request, $id)
    {
        $rentalcompany = \App\Models\Rentalcompany::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'logo' => 'required|string|max:255'
        ]);
        
        $rentalcompany->update($validated);
        
        return redirect()->route('dashboard.rentalcompanies.index')->with('success', 'Rentalcompany updated successfully.');
    }

        public function destroy($id)
    {
        $rentalcompany = \App\Models\Rentalcompany::findOrFail($id);
        $rentalcompany->delete();
        return redirect()->route('dashboard.rentalcompanies.index')->with('success', 'Rentalcompany deleted successfully.');
    }
    public function restore($id)
    {
        $rentalcompany = \App\Models\Rentalcompany::withTrashed()->findOrFail($id);
        $rentalcompany->restore();
        return redirect()->route('dashboard.rentalcompanies.index')->with('success', 'Rentalcompany restored successfully.');
    }
}