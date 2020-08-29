<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\BikeHistories;

class APIBikehistoriesController extends Controller
{
    public function index(){
        $bikeshistories= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.saved_at as created_at','bike_histories.rating')
        ->orderby('id','desc')
        ->get();
        return response()->json($bikeshistories, 200);
    }

    public function showByCustomer($id){
        $bikeshistories= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.rating','bike_histories.saved_at as created_at')
        ->where('bike_histories.cust_id','=',$id)
        ->orderby('id','desc')
        ->get();
        
        return response()->json($bikeshistories, 200);
        // if (is_null($bikeshistories)) {
        //     return response()->json([
        //         'message' => 'Resource not found!'
        //     ],404);
        // }else{
        //     return response()->json($bikeshistories, 200);
        // }
    }

    public function showByWorker($id){
        $bikeshistories= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.rating','bike_histories.saved_at as created_at')
        ->where('bike_histories.worker_id','=',$id)
        ->orderby('id','desc')
        ->get();
        
        // $sumBikehistories= DB::table('bike_histories')->where('worker_id','=',$id)->count();
       
        if (is_null($bikeshistories)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikeshistories, 200);
        }
    }
    
    public function countByWorker($id){
        
        $sumBikehistories= ['total'=>DB::table('bike_histories')->where('worker_id','=',$id)->count()];
       
        if (is_null($sumBikehistories)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($sumBikehistories, 200);
        }
    }

    public function updateRating(Request $request,$id){ 
        $data = BikeHistories::find($id);
        $data->rating = $request['rating'];
        $data->update();
        return response()->json('success', 201);
    }
}
