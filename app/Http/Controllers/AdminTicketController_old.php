<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;

class AdminTicketController_old extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    // Admin ticket list.
    public function ticketList(Request $request)
    {
        $sn = 1;
        $tickets = Ticket::orderBy('created_at','desc')->get();
        return view('admin.ticket_list',compact('tickets','sn'));
    }

    // Admin ticket detail.
    public function ticketDetail(Request $request)
    {
        $ticket = Ticket::where('salted_hash_id',$request->id)->first();
        return view('admin.ticket_detail',compact('ticket'));
    }

    // Admin ticket comment create.
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

            // Response
            $data['success'] = 1;
            $data['message'] = 'Updated Successfully!';
        } else {
            $data['success'] = 0;
            $data['message'] = 'Not Updated';
        }

        return response()->json($data);
    }

    // Admin ticket status update.
    public function ticketStatusUpdate(Request $request)
    {
        $tickets = Ticket::where('salted_hash_id',$request->ticket)->update(['status' => $request->status]);
        $data['success'] = 1;
        $data['message'] = 'Updated Successfully!';

        return response()->json($data);
    }
}
