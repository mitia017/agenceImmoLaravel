<?php

namespace App\Http\Controllers;

use App\Models\property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index ()
    {
        $properties = property::orderBy('created_at', 'desc')->where('sold', false)->limit(3)->get();
        return view('home', [
            'properties' => $properties
        ]);
    }
}
