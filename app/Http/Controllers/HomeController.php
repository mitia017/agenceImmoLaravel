<?php

namespace App\Http\Controllers;

use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('created_at', 'desc')->where('sold', false)->limit(3)->get();

        return view('home', [
            'properties' => $properties,
        ]);
    }
}
