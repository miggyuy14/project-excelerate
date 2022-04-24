<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function welcome()
    {
        return Inertia::render('Welcome');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('welcome'));
    }
}
