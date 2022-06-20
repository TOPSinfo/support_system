<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;
use App\Models\Activity;
use Auth;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createTicket(Request $request)
    {
        return view("ticket.add");
    }

    public function saveTicket(SaveTicketRequest $request)
    {
        $data = array(
                'salted_hash_id' => hashSalt('tickets'),
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => Auth::guard('web')->user()->id,
                'lastmodified_by_type' => '1',
                'lastmodified_by' => Auth::guard('web')->user()->id,
        );

        $ticket = Ticket::create($data);

        $activity = array(
                'salted_hash_id' => hashSalt('activities'),
                'ticket_id' => $ticket->id,
                'activity_type' => '1',
                'created_by' => Auth::guard('web')->user()->id,
                'lastmodified_by_type' => '1',
                'lastmodified_by' => Auth::guard('web')->user()->id,
        );
        Activity::create($activity);
        return redirect()->back()->with('success', 'Ticket added successfully.'); 
    }

    public function editTicket($id)
    {
        $tickets = Ticket::where('salted_hash_id',$id)->first();
        return view("ticket.edit", compact('tickets'));
    }

    public function updateTicket(SaveTicketRequest $request)
    {
        $data = array(
                'title' => $request->title,
                'description' => $request->description,
                'lastmodified_by_type' => '1',
                'lastmodified_by' => Auth::guard('web')->user()->id,
        );

        Ticket::where('salted_hash_id',$request->id)->update($data);
    }

    public function viewTicket(SaveTicketRequest $request)
    {
        $tickets = Ticket::where('salted_hash_id',$request->id)->first();
        return view("ticket.view", compact('tickets'));
    }

    public function listTicket(Request $request)
    {
        $sn = 1;
        $tickets = Ticket::get();
        return view("ticket.list", compact('tickets','sn'));
    }
}
