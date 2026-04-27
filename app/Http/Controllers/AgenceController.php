<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyContactRequest;
use App\Http\Requests\SearchPropertiesRequest;
use App\Models\Option;
use App\Models\Property;
use App\Models\User;
use App\Notifications\NewPropertyRequest;

class AgenceController extends Controller
{
    public function index(SearchPropertiesRequest $request)
    {
        $query = Property::query()->where('sold', false)->orderBy('created_at', 'desc');
        if ($request->validated('price')) {
            $query = $query->where('price', '<=', $request->validated('price'));
        }
        if ($request->validated('surface')) {
            $query = $query->where('surface', '>=', $request->validated('surface'));
        }
        if ($request->validated('rooms')) {
            $query = $query->where('rooms', '>=', $request->validated('rooms'));
        }
        if ($request->validated('title')) {
            $query = $query->where('title', 'like', "%{$request->validated('title')}%");
        }

        return view('property.index', [
            'properties' => $query->paginate(12),
            'input' => $request->validated(),
        ]);

    }

    public function show(string $slug, Property $property)
    {
        $expectedSlug = $property->getSlug();

        if ($slug !== $expectedSlug) {
            return to_route('property.show', [
                'slug' => $expectedSlug,
                'property' => $property,
            ]);
        }

        // 🔥 Charger les relations nécessaires
        $property->load('images');
        $images = $property->images
            ->map(fn ($img) => asset('storage/'.$img->path));

        return view('property.show', [
            'property' => $property,
            'options' => Option::pluck('name', 'id'),
            'images' => $images,
        ]);
    }

    public function contact(Property $property, PropertyContactRequest $request)
    {
        // dd($request->validated());
        $recipients = collect();
        $superadmins = User::where('role', 'superadmin')->get();
        $recipients = $recipients->merge($superadmins);
        if ($property->user()) {
            $recipients->push($property->user);
        }
        $recipients = $recipients->unique('id');
        foreach ($recipients as $user) {
            $user->notify(new NewPropertyRequest($property, $request->all()));
        }
        $recipients = null;

        return back()->with('success', 'Votre demande de contact a bien été envoyé');
    }
}
