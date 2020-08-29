<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\CarpetHistories;

class APICarpethistoriesController extends Controller
{
    public function index(){
        $carpetshistories= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.saved_at as created_at','carpet_histories.rating')
        ->orderby('id','asc')->get();
        return response()->json($carpetshistories, 200);
    }

    public function showByCustomer($id){
        $carpetshistories= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.created_at','carpet_histories.rating','carpet_histories.saved_at as created_at')
        ->where('carpet_histories.cust_id','=',$id)
        ->get();
       
        if (is_null($carpetshistories)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpetshistories, 200);
        }
    }

    public function showByWorker($id){
        $carpetshistories= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.created_at','carpet_histories.rating','carpet_histories.saved_at as created_at')
        ->where('carpet_histories.worker1_id','=',$id)
        ->orwhere('carpet_histories.worker2_id','=',$id)
        ->get();
        
        //  $sumCarpetshistories= DB::table('carpet_histories')->where('worker1_id','=',$id)->orwhere('worker2_id','=',$id)->count();
       
        if (is_null($carpetshistories)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpetshistories, 200);
        }
    }
    
    public function countByWorker($id){
        
        $sumCarpetshistories= ['total'=>DB::table('carpet_histories')->where('worker1_id','=',$id)->orwhere('worker2_id','=',$id)->count()];
       
        if (is_null($sumCarpetshistories)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($sumCarpetshistories, 200);
        }
    }

    public function updateRating(Request $request,$id){ 
        $data = CarpetHistories::find($id);
        $data->rating = $request['rating'];
        $data->update();
        return response()->json('success', 201);
    }
}
