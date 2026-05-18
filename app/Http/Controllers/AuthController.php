<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        $departments = Department::where('is_active', true)->get();

        return view('auth.register', compact('departments'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_identifier' => ['required', 'string', 'max:50', 'unique:users,user_identifier'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'user_type' => ['required', 'in:student,department_admin,super_admin'],
            'department_id' => ['nullable', 'required_if:user_type,department_admin', 'exists:departments,id'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'user_identifier' => $validated['user_identifier'],
            'email' => $validated['email'],
            'department_id' => $validated['user_type'] === 'department_admin' ? $validated['department_id'] : null,
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
