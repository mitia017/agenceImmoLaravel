<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;
use App\Models\Option;

class PropertyController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $properties = Property::paginate(10);
        } else {
            $properties = Property::where('user_id', $user->id)->paginate(10);
        }
        return view('admin.properties.index', [
            'properties' => $properties
        ]);
    }

    public function create()
    {
        $property = new Property();
        $property->fill([
            'surface' => 40,
            'rooms' => 3,
            'bedrooms' => 1,
            'floor' => 0,
            'city' => 'Montpellier',
            'postal_code' => 34000,
            'sold' => false,
        ]);
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id'),
        ]);
    }

    
    public function store(PropertyRequest $request)
    {
        $property = Property::create(array_merge(
            $request->except('images'),
            ['user_id' => auth()->id()] 
        ));

        
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('properties', 'public');

                $property->images()->create([
                    'path' => $path
                ]);
            }
        }
        
        $property->options()->sync($request->validated('options'));
        return to_route('admin.property.index')->with('success', 'Le bien a bien été créé');
    }
    
    

    public function edit(Property $property)
    {
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id'),
        ]);
    }

    public function update(PropertyRequest $request, Property $property)
{
    $property->update($request->except('images'));

    $property->options()->sync($request->validated('options'));

    if ($request->has('delete_images')) {
        foreach ($property->images()->whereIn('id', $request->delete_images)->get() as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('properties', 'public');

            $property->images()->create([
                'path' => $path
            ]);
        }
    }

    return to_route('admin.property.index')
        ->with('success', 'Le bien a bien été modifié');
}

    public function destroy(Property $property)
    {
        $property->delete();
        return to_route('admin.property.index')->with('success', 'Le bien a bien été supprimé');
    }
}
