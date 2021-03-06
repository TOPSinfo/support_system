<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\User;
use Auth;
use App\Jobs\SendEmailJob;

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

    // Front ticket add form.
    public function createTicket(Request $request)
    {
        return view("ticket.add");
    }

    // Front ticket add form submit.
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

        $admin_users = User::where('is_admin','1')->get();
        $details = array();
        foreach ($admin_users as $key => $user) {
            $details['email'] = $user->email;
        }
        if (!empty($details)) {
            dispatch(new SendEmailJob($details));
        }

        return redirect()->route('ticket.list')->with('success', 'Ticket added successfully.');
    }

    // Front ticket edit form.
    public function editTicket($id)
    {
        $tickets = Ticket::where('salted_hash_id',$id)->first();
        return view("ticket.edit", compact('tickets'));
    }

    // Front ticket edit form submit.
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

    // Front ticket view page.
    public function viewTicket(Request $request, $id)
    {
        $ticket = Ticket::where('salted_hash_id',$id)->first();
        return view("ticket.detail", compact('ticket'));
    }

    // Front ticket comment create.
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

    // Front ticket List.
    public function listTicket(Request $request)
    {
        $sn = 1;
        $an = 1;
        $tickets = Ticket::where('created_by',Auth::guard('web')->user()->id)->orderBy('created_at','desc')->get();
        $activity = Activity::where('created_by',Auth::guard('web')->user()->id)->skip(0)->take(5)->orderBy('created_at','desc')->get();
        return view("ticket.list", compact('tickets','sn','activity','an'));
    }
}
