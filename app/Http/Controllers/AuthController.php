<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('admin.property.index'))->with('success', 'Connexion réussie');
        }

        return back()->withErrors([
            'email' => 'identifiant incorrect'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login')->with('success', 'Déconnecté avec succès');
    }
}
