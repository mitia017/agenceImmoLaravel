<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.property.index'))->with('success', 'Connexion réussie');
        }

        return back()->withErrors([
            'email' => 'identifiant incorrect',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login')->with('success', 'Déconnecté avec succès');
    }
}
