<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blotter;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDataController extends Controller
{
    public function residents()
    {
        $residents = User::whereHas('roles', function ($query) {
            $query->where('roles.name', 'resident');
        })->get()->count();

        return $residents;
    }

    public function brgy()
    {
        $brgy = User::whereHas('roles', function ($query) {
            $query->where('roles.name', 'staff');
        })->get()->count();

        return $brgy;
    }

    public function tickets()
    {
        $ticket = Ticket::get()->count();

        return $ticket;
    }

    public function resident($id)
    {
        $residents = User::with('profile')->find($id);

        return $residents;
    }

    public function blotters()
    {
        $ticket = Blotter::get()->count();

        return $ticket;
    }

    public function blotter($id)
    {
        $blotter = Blotter::with('creator')->find($id);

        return $blotter;
    }
}
