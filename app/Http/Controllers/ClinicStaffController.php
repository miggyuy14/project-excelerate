<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClinicStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function doctors()
    {
        $user = Auth::user();
        $doctors = User::with('profile')
        ->whereHas('roles', function ($query) {
            $query->where('roles.name', 'doctor');
        })
        ->where('id', '<>', $user->id)
        ->paginate(10);

        return Inertia::render('Admin/Clinic/Staff/Index', [
            'data' => $doctors
        ]);
    }

    public function nurses()
    {
        $user = Auth::user();
        $nurses = User::with('profile')
        ->whereHas('roles', function ($query) {
            $query->where('roles.name', 'nurse');
        })
        ->where('id', '<>', $user->id)
        ->paginate(10);

        return Inertia::render('Admin/Clinic/Staff/Index', [
            'data' => $nurses
        ]);
    }

    public function residents()
    {
        $user = Auth::user();
        $nurses = User::with('profile')
        ->where('id', '<>', $user->id)
        ->paginate(10);

        return Inertia::render('Admin/Clinic/Staff/Index', [
            'data' => $nurses
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

    public function createDoctor($id)
    {
        $leader = User::find($id);

        $leader->detachRole('resident');
        $leader->attachRole('doctor');

        return redirect()->back()->with('success', 'Doctor successfully added');
    }

    public function createNurse($id)
    {
        $leader = User::find($id);

        $leader->detachRole('resident');
        $leader->attachRole('nurse');

        return redirect()->back()->with('success', 'Nurse successfully added');
    }
}
