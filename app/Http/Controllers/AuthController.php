<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function staffloginview()
    {
        return view('auth.staff-login');
    }

    public function staffregisterview()
    {
        return view('auth.staff-register');
    }

    public function staffregister(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($validatedData);

        Auth::login($user);

        return redirect('/staff-login')->with('success', 'Registration successful. Please log in.');
    }

    public function stafflogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/tickets');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Try Again.',
        ])->onlyInput('email');
    }

    public function stafflogout(Request $request)
    {
        Auth::logout(); // Log out the user
        $request->session()->invalidate(); // Delete session cookies
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('/staff-login'); // Redirect to login page
    }

}
