<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarpetHistoriesExport;
use App\Workers;

class CarpethistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carpetshistoriesList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.saved_at')
        ->orderby('id','asc')->get();
        // dd($carpetshistoriesList);
        return view('admin.carpethistoriesView.index',compact('carpetshistoriesList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOwner()
    {
        $carpetshistoriesList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.saved_at')
        ->orderby('id','asc')->get();
        // dd($carpetshistoriesList);
        return view('owner.carpethistoriesView.index',compact('carpetshistoriesList'));
    }

    public function exportCarpetHistories(){
        return Excel::download(new CarpetHistoriesExport,'CarpetHistories.xlsx');
    }
    
    public function findByWorker(Request $request){
        $workerName = $request->except('_token','updated_at','created_at');
        $workerData = Workers::select('id')
            ->where('name', '=', $workerName)
            ->get()->toArray();
        $carpetshistoriesList = DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_pay','carpet_histories.total_disc','carpet_histories.pay_status','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.type_of_payment','carpet_histories.saved_at')
        ->where('worker1_id', '=', $workerData)
        ->orWhere('worker2_id', '=', $workerData)
        ->orderby('id','asc')->get();
        return view('admin.carpethistoriesView.index',compact('carpetshistoriesList'));
    }
}
