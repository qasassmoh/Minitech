<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredAdminController extends Controller
{
    /**
     * Display the admin registration view.
     * Separate registration form for admin users
     */
    public function create(): View
    {
        return view('auth.register-admin');
    }

    /**
     * Handle an incoming admin registration request.
     * Creates a new user with 'admin' role
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the admin registration request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create admin user with 'admin' role
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role to 'admin' for admin registration
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to home page (shows job posts) - admin can access admin panel from navigation
        return redirect(route('home', absolute: false));
    }
}
