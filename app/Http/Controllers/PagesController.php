<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
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
}
