<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminUserManagementController extends Controller
{

    public function residents()
    {
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('staff')){
            $data = User::with('profile')
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'resident');
                })
                ->paginate(10);
        }else if($user->hasRole('zone_leader')){
           $data = User::with('profile')
                ->whereHas('profile', function ($query) use ($user) {
                    $query->where('zone_id', $user->profile[0]->zone_id);
                })
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'resident');
                })
                ->paginate(10);
        }

        return Inertia::render('Admin/Users/Index', [
            'data' => $data,
        ]);
    }

    public function access()
    {
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('staff')){
            $data = User::with('profile')
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'resident');
                })
                ->where('active', 0)
                ->paginate(10);
        }else if($user->hasRole('zone_leader')){
            $data = User::with(['profile' => function ($query) use ($user) {
                $query->where('zone_id', $user->profile[0]->zone_id);
            }])
            ->where('active', 0)
            ->where('id', '<>',$user->id)
            ->paginate(10);
        }

        return Inertia::render('Admin/Users/Index', [
            'data' => $data,
        ]);
    }

    public function officials()
    {
        $data = User::with('profile')
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'staff');
                })
                ->paginate(10);

        return Inertia::render('Admin/Users/Index', [
            'data' => $data,
        ]);
    }

    public function leaders()
    {
        $data = User::with('profile')
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'zone_leader');
                })
                ->paginate(10);

        return Inertia::render('Admin/Users/Index', [
            'data' => $data,
        ]);
    }

    public function clinic()
    {
        $data = User::with('profile')
                ->whereHas('roles', function ($query) {
                    $query->where('roles.name', 'nurse')
                        ->orWhere('roles.name', 'doctor');
                })
                ->paginate(10);

        return Inertia::render('Admin/Users/Index', [
            'data' => $data,
        ]);
    }

    public function approve($id)
    {
        $user = User::find($id);

        $user->active = 1;

        $user->save();

        return redirect()->back()->with('success', 'Access Approved');
    }

    public function deactivate($id)
    {
        $user = User::find($id);

        $user->active = 2;

        $user->save();

        return redirect()->back()->with('success', 'Access Deactivated');
    }

    public function createLeader($id)
    {
        $leader = User::find($id);

        $leader->detachRole('resident');
        $leader->attachRole('zone_leader');

        return redirect()->back()->with('success', 'Leader successfully added');
    }

    public function removeLeader($id)
    {
        $leader = User::find($id);

        $leader->detachRole('leader');
        $leader->attachRole('resident');

        return redirect()->back()->with('success', 'Leader successfully added');
    }

    public function createOfficial($id)
    {
        $official = User::find($id);

        $official->detachRole('resident');
        $official->attachRole('staff');

        return redirect()->back()->with('success', 'Official successfully added');
    }

    public function removeOfficial($id)
    {
        $official = User::find($id);

        $official->detachRoles();
        $official->attachRole('resident');

        return redirect()->back()->with('success', 'Role successfully removed');
    }
}
