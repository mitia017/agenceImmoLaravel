<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

// app/Http/Controllers/UserController.php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:owner,agent',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé !');
    }

    public function updateRole(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);

        $request->validate([
            'role' => 'required|in:owner,agent',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Rôle mis à jour !');
    }

    public function destroy(User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        
        if($currentUser->role === 'superadmin')
        {
            $user->delete();
            return Redirect::back()->with('success', 'Utilisateur supprimé avec succès.');
        }
        
    }
}