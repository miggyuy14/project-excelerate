<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('resident')){
            $tickets = Ticket::with(['status', 'requestor.profile'])->where('user_id', $user->id)->paginate(10);

            return Inertia::render('Tickets',[
                'tickets' => $tickets,
            ]);
        }else if($user->hasRole('zone_leader')){
            $tickets = Ticket::with(['status', 'requestor.profile'])
                ->where('zone_id', $user->profile[0]->zone_id)
                ->paginate(10);

            return Inertia::render('Tickets',[
                'tickets' => $tickets,
            ]);
        }else{
            $tickets = Ticket::with(['status', 'requestor.profile'])->paginate(10);

            return Inertia::render('Tickets',[
                'tickets' => $tickets,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = RequestType::all();
        return Inertia::render('Residents/Create', [
            'types' => $type
        ]);
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
            $ticket = Ticket::create([
                'request_type' => $request->request_type['name'],
                'description' => $request->description,
                'user_id' => $user->id,
                'zone_id' =>  $request->zone_id,
                'status_id' => 1,
            ]);

            return redirect(route('ticket.index'))->with('success', 'Ticket Created Successfully');
        }
        catch(\Exception $e){
            Log::error($e);
            return redirect(route('ticket.index'))->with('error', 'There is an issue with creating a ticket please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ticket = Ticket::with(['status', 'requestor.profile'])->find($request->id);
        // dd($ticket);
        return $ticket;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function approve(Request $request)
    {
        try{
            $ticket = Ticket::find($request->id);
            $ticket->or_no = $request->or_no;
            $ticket->amount = $request->amount;
            $ticket->approved_by = Auth::id();
            $ticket->approved_at = Carbon::now();
            $ticket->status_id = 2;

            $ticket->save();

            return redirect(route('ticket.index'))->with('success', 'Ticket Approved Successfully');
        }
        catch (\Exception $e){
            Log::error($e);

            return redirect(route('ticket.index'))->with('error', 'Something Went Wrong Please Contact Admin');
        }
    }
}
