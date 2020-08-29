<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BikeHistories;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BikeHistoriesExport;
use App\Workers;

class BikehistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikeshistoriesList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.saved_at')
        ->orderby('id','asc')->get();
        // dd($bikeshistoriesList);
        return view('admin.bikehistoriesView.index',compact('bikeshistoriesList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOwner()
    {
        $bikeshistoriesList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.saved_at')
        ->orderby('id','asc')->get();
        // dd($bikeshistoriesList);
        return view('owner.bikehistoriesView.index',compact('bikeshistoriesList'));
    }

    public function exportBikeHistories(){
        return Excel::download(new BikeHistoriesExport,'BikeHistories.xlsx');
    }
    
    public function findByWorker(Request $request){
        $workerName = $request->except('_token','updated_at','created_at');
        $workerData = Workers::select('id')
            ->where('name', '=', $workerName)
            ->get()->toArray();
        $bikeshistoriesList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.saved_at')
        ->where('worker_id', '=', $workerData)
        ->orderby('id','asc')->get();
        return view('admin.bikehistoriesView.index',compact('bikeshistoriesList'));
    }
}
