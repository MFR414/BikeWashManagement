<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\BikeQueues;

class APIBikebookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikequeuesList= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.status','bike_queues.booking_date','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','customers.name as customer','wash_type.wash_type')
        ->where('bike_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('id','asc')->get();
        return response()->json($bikequeuesList, 200);
    }

    public function show($id){
        $bikequeuesList= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.status','bike_queues.booking_date','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','customers.name as customer','wash_type.wash_type')
        ->where('bike_queues.id','=',$id)
        ->where('bike_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get();
       
        if (is_null($bikequeuesList)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikequeuesList, 200);
        }
    }

    public function showByUser($id){
        $bikequeuesList= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.status','bike_queues.booking_date','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','customers.name as customer','wash_type.wash_type')
        ->where('bike_queues.customer_id','=',$id)
        ->where('bike_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get();
       
        if (is_null($bikequeuesList)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikequeuesList, 200);
        }
    }

    public function destroy($id){
        BikeQueues::find($id)->delete();
        return response()->json('success', 200);
    }
}
