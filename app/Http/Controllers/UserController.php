<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
        })->get();

        return view('user.index', ['users' => $users, 'searchTerm' => $searchTerm]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        user::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users')->with('error', 'User not found.');
        }

        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6', // Optional password field
        ]);
    
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('users')->with('error', 'User not found.');
        }
    
        // Update user data
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
    
        // Check if password is provided in the request
        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->input('password'));
        }
    
        $user->update($userData);
    
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    
    public function destroy(User $user)
    {
        $user->load('links');
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function disable(User $user)
    {
        $user->is_disabled=1;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User disabled successfully.');
    }
    public function enable(User $user)
    {
        $user->is_disabled=0;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User enabled successfully.');
    }
}
