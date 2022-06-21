<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Comment;
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
        return redirect()->route('ticket.list')->with('success', 'Ticket added successfully.');
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
        $ticket = Ticket::where('salted_hash_id',$request->id)->first();
        return redirect()->route('ticket.list')->with('success', 'Ticket updated successfully.');
    }

    public function viewTicket(Request $request, $id)
    {
        $ticket = Ticket::where('salted_hash_id',$id)->first();
        return view("ticket.detail", compact('ticket'));
    }

    public function ticketComment(Request $request)
    {
        if($request->file('attachment')) {
            $file = $request->file('attachment');
            $filename = time().'_'.$file->getClientOriginalName();

            // File extension
            $extension = $file->getClientOriginalExtension();

            // File upload location
            $location = 'files';

            // Upload file
            $file->move($location,$filename);

            // File path
            $filepath = url('files/'.$filename);
        } else {
            $filename = null;
        }

        if (!empty($request->comment) || !empty($filename)) {
            $arr = array(
                'salted_hash_id' => hashSalt('comments'),
                'ticket_id' => $request->ticket_id,
                'message' => $request->comment,
                'image_name' => $filename,
                'created_by' => Auth::guard('web')->user()->id,
            );

            Comment::create($arr);

            $ticket = Ticket::where('id',$request->ticket_id)->first();
            $activity = array(
                'salted_hash_id' => hashSalt('activities'),
                'ticket_id' => $ticket->id,
                'activity_type' => '2',
                'created_by' => Auth::guard('web')->user()->id,
                'lastmodified_by_type' => '1',
                'lastmodified_by' => Auth::guard('web')->user()->id,
            );
            Activity::create($activity);

            // Response
            $data['success'] = 1;
            $data['message'] = 'Updated Successfully!';
        } else {
            $data['success'] = 0;
            $data['message'] = 'Not Updated';
        }

        return response()->json($data);
    }

    public function listTicket(Request $request)
    {
        $sn = 1;
        $tickets = Ticket::where('created_by',Auth::guard('web')->user()->id)->orderBy('created_at','desc')->get();
        $activity = Activity::where('created_by',Auth::guard('web')->user()->id)->skip(0)->take(5)->orderBy('created_at','desc')->get();
        return view("ticket.list", compact('tickets','sn','activity'));
    }
}
