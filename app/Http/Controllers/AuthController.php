<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function stafflogin()
    {
        return view('auth.staff-login');
    }

    public function staffregister()
    {
        return view('auth.staff-register');
    }

    public function staffregisterpost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'confirm_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed|same:confirm_password',
        ]);

        $user = User::create($validatedData);

        Auth::login($user);

        return redirect('/tickets');
    }

    public function staffloginpost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/tickets');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    
}
