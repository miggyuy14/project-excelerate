<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultations = Consultation::with('patient', 'status')->paginate(10);

        return Inertia::render('Admin/Clinic/Index', [
            'consultations' => $consultations
        ]);
    }

    public function residents()
    {
        $user = Auth::user();
        $consultations = Consultation::with('patient', 'status')
            ->where('user_id', $user->id)
            ->paginate(10);

        return Inertia::render('Consultations', [
            'consultations' => $consultations
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
        $user = Auth::user();
        try {
            $consultation = Consultation::create([
                'request_type' => 'Consultation',
                'description' => $request->description,
                'user_id' => $user->id,
                'status_id' => 1,
                'consultation_date' => Carbon::parse($request->date),
            ]);

            return redirect()->back()->with('success', 'Consultation created!');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong please contact admin');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $consultation = Consultation::find($id);

        $consultation->findings = $request->findings;
        $consultation->save();

        return redirect()->back()->with('success', 'Consultation updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        //
    }

    public function approve($id)
    {
        $consultation = Consultation::find($id);

        $consultation->status_id = 2;
        $consultation->save();

        return redirect()->back()->with('success', 'Consultation approved!');
    }

    public function reject($id,Request $request)
    {
        $consultation = Consultation::find($id);
        // dd($request->reason);

        $consultation->reason = $request->reason;
        $consultation->status_id = 3;
        $consultation->save();

        return redirect()->back()->with('success', 'Consultation rejected!');
    }

    public function firstDose($id)
    {
        $consultation = Profile::find($id);

        $consultation->first_dose = Carbon::now();
        $consultation->save();

        return redirect()->route('clinic.residents')->with('success', 'First dose added!');
    }

    public function secondDose($id)
    {
        $consultation = Profile::find($id);

        $consultation->second_dose = Carbon::now();
        $consultation->save();

        return redirect()->back()->with('success', 'Second dose added!');
    }

    public function booster($id)
    {
        $consultation = Profile::find($id);

        if($consultation->booster == null || $consultation->booster == ''){
            $consultation->booster = Carbon::now();
            $consultation->booster_count = 1;
            $consultation->save();

            return redirect()->route('clinic.residents')->with('success', 'booster added!');
        }else {
            $consultation->booster = Carbon::now();
            $consultation->booster_count = $consultation->booster_count + 1;
            $consultation->save();

            return redirect()->route('clinic.residents')->with('success', 'booster updated!');
        }

    }
}
