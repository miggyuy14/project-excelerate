<?php

namespace App\Http\Controllers;

use App\Models\Blotter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BlotterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blotters = Blotter::with('creator')->paginate(10);

        return Inertia::render('Admin/Blotter/Index', [
            'blotters' => $blotters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return Inertia::render('Admin/')
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            Blotter::create([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'created_by' => $user->id,
            ]);

            return redirect(route('admin.blotter'))->with('success', 'Blotter Created Successfully');
        } catch (\Exception $e) {
            Log::error($e);

            return redirect(route('admin.blotter'))->with('error', 'Something went wrong with creating blotter please contact admin');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blotter  $blotter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blotter  $blotter
     * @return \Illuminate\Http\Response
     */
    public function edit(Blotter $blotter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blotter  $blotter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blotter $blotter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blotter  $blotter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blotter $blotter)
    {
        //
    }
}
