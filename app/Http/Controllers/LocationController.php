<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Locations\Location; 

class LocationController extends Controller
{
    public function index()
    {
        return Inertia::render('Locations/Index', [
            'locations' => Location::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Locations/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'scope' => 'required|in:Interno,Externo'
        ]);

        
        Location::create($data);

        return redirect()->route('locations.index');
    }

    public function edit(Location $location)
    {
        return Inertia::render('Locations/Edit', [
            'location' => $location
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'scope' => 'required|in:Interno,Externo'
        ]);

        $location->update($data);

        return redirect()->route('locations.index');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index');
    }
}