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
            $data = User::with(['profile' => function ($query) use ($user) {
                $query->where('zone_id', $user->profile[0]->zone_id);
            }])
            ->where('id', '<>',$user->id)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
