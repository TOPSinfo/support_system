<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function viewTicket(Request $request)
    {
        $tickets = Ticket::get();
        return view('admin.ticket_list',compact('tickets'));
    }
}
