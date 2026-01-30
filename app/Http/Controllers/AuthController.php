<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
