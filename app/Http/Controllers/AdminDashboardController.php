<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    // Get dashboard of the admin.
    public function dashboard(Request $request)
    {
        $completed = Ticket::where('status','3')->count();
        $rejected = Ticket::where('status','4')->count();
        $pending = Ticket::where('status','2')->count();
        if (!empty($completed) || !empty($rejected)) {
            $success_per = ($completed / ($completed + $rejected )) * 100;
        } else {
            $success_per = 0;
        }
        return view('admin.dashboard', compact('completed','rejected','pending','success_per'));
    }
}
