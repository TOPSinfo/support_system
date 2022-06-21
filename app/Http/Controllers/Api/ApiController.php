<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;

class ApiController extends Controller
{
    public function __invoke(Request $request)
    {

    }

    public function __construct()
    {
        $this->apiKey = 'test@123';
        $this->apiErr = 'Sorry we are unable to allow you check api key.';
        $this->apiStatus = 400;
        $this->status = 200;
        $this->msg = 'Error in request.';
        $this->bdata = new \stdClass();
    }
    
    // for checking api key
    public function checkApiKey($api_key)
    {
        if ($api_key != $this->apiKey) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Display a listing of the tickets.
     *
     * @return json
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_value' => 'required',
        ]); 
        if ($validator->fails())
        { 
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->type == '2') {
            $validator = Validator::make($request->all(), [
                'year' => 'required',
            ]); 
            if ($validator->fails())
            { 
                return response(['errors'=>$validator->errors()->all()], 422);
            }
        }
        if ($this->checkApiKey($request->api_key)) { return
            response()->json([
                'message' => $this->apiErr,
                'status' => $this->apiStatus,
                'data' => $this->bdata,
            ]);
        }
        if ($request->type == 'daily') {
            $completed = Ticket::where('status','3')->whereBetween('created_at', [$request->type_value.' 00:00:01', $request->type_value.' 23:59:59'])->get();
            $rejected = Ticket::where('status','4')->whereBetween('created_at', [$request->type_value.' 00:00:01', $request->type_value.' 23:59:59'])->get();
            if (!empty($completed->count()) || !empty($rejected->count())) {
                $success_per = ($completed->count() / ($completed->count() + $rejected->count() )) * 100;
            } else {
                $success_per = 0;
            }
        } elseif ($request->type == 'monthly') {
            $completed = Ticket::where('status','3')->whereBetween('created_at', [date('Y-m-d', strtotime($request->year.'-'.$request->type_value.'-01')).' 00:00:01', date('Y-m-t', strtotime($request->year.'-'.$request->type_value)).' 23:59:59'])->get();
            $rejected = Ticket::where('status','4')->whereBetween('created_at', [date('Y-m-d', strtotime($request->year.'-'.$request->type_value.'-01')).' 00:00:01', date('Y-m-t', strtotime($request->year.'-'.$request->type_value)).' 23:59:59'])->get();
            if (!empty($completed->count()) || !empty($rejected->count())) {
                $success_per = ($completed->count() / ($completed->count() + $rejected->count() )) * 100;
            } else {
                $success_per = 0;
            }
        }

        $success_per = round($success_per,2);

        $response[] = array(
            'completed_count' => $completed->count(),
            'rejected_count' => $rejected->count(),
            'success_percentage' => $success_per,
        );

        $response[] = array(
            'completed' => $completed,
            'rejected' => $rejected,
        );

        return response()->json([
            'message' => 'Success',
            'status' => $this->status,
            'data' => $response,
        ]);
    }
}
