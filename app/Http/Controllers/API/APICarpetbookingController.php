<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\CarpetQueues;

class APICarpetbookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carpets = DB::table('carpet_queues')
        ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
        ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
        ->select('carpet_queues.id','carpet_queues.status','carpet_queues.booking_date','customers.name as customer','carpets.color_of_carpet','carpets.type_of_carpet','wash_type.wash_type')
        ->where('carpet_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('id','asc')->get();
        return response()->json($carpets, 200);
    }

    public function show($id){
        $carpets = DB::table('carpet_queues')
        ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
        ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
        ->select('carpet_queues.id','carpet_queues.status','carpet_queues.booking_date','customers.name as customer','carpets.color_of_carpet','carpets.type_of_carpet','wash_type.wash_type')
        ->where('carpet_queues.id','=',$id)
        ->where('carpet_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get();
       
        if (is_null($carpets)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpets, 200);
        }
    }

    public function showByUser($id){
        $carpets = DB::table('carpet_queues')
        ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
        ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
        ->select('carpet_queues.id','carpet_queues.status','carpet_queues.booking_date','customers.name as customer','carpets.color_of_carpet','carpets.type_of_carpet','wash_type.wash_type')
        ->where('carpet_queues.customer_id','=',$id)
        ->where('carpet_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get();
       
        if (is_null($carpets)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpets, 200);
        }
    }

    public function destroy($id){
        CarpetQueues::find($id)->delete();
        return response()->json('success', 200);
    }
}
