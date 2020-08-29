<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BikereportController extends Controller
{
    public function dailyIndex(){
        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.type_of_payment','bike_histories.total_pay','bike_histories.saved_at')
        ->where('bike_histories.saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('id','asc')->get();
        // dd($bikeshistoriesList);

        $sumreport=DB::table('bike_histories')->where('saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())->sum('total_pay');

        // dd( $bikesreportList->saved);

        $dayStrict=['min_date'=>Carbon::now()->firstOfMonth()->toDateString(),'max_date'=>Carbon::now()->lastOfMonth()->toDateString()];
        return view('admin.bikereportView.dailyindex',compact('bikesreportList','dayStrict','sumreport'));
    }

    public function dailyIndexByDate(Request $request){
        $date=$request->except('_token','updated_at','created_at');
        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.total_pay','bike_histories.total_disc','bike_histories.paid_amount','bike_histories.changes','bike_histories.type_of_payment','bike_histories.saved_at')
        ->where('bike_histories.saved_at','=',$date['date_filter'])
        ->orderby('id','asc')->get();
        // dd($bikeshistoriesList);

        $sumreport=DB::table('bike_histories')->where('saved_at','=',$date['date_filter'])->sum('total_pay');

        $dayStrict=['min_date'=>Carbon::now()->firstOfMonth()->toDateString(),'max_date'=>Carbon::now()->lastOfMonth()->toDateString()];
        return view('admin.bikereportView.dailyindex',compact('bikesreportList','dayStrict','sumreport'));
    }

    public function monthlyIndex(){
        $firstdate = Carbon::now('Asia/Jakarta')->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->endOfMonth()->toDateString();

        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.total_pay','bike_histories.saved_at')
        ->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('bike_histories')->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.bikereportView.monthlyindex',compact('bikesreportList','sumreport'));
    }
    public function monthlyIndexByDate(Request $request){
        $params = $request->except('_token','updated_at','created_at');
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth($params['month_filter'])->setYear($params['year_filter'])->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth($params['month_filter'])->setYear($params['year_filter'])->endOfMonth()->toDateString();
        // dd($firstdate);

        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.total_pay','bike_histories.saved_at')
        ->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('bike_histories')->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.bikereportView.monthlyindex',compact('bikesreportList','sumreport'));
    }

    public function yearlyIndex(){
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth(01)->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth(12)->endOfMonth()->toDateString();

        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.total_pay','bike_histories.saved_at')
        ->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('bike_histories')->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.bikereportView.yearlyindex',compact('bikesreportList','sumreport'));
    }

    public function yearlyIndexByDate(Request $request){
        $params = $request->except('_token','updated_at','created_at');
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth(01)->setYear($params['year_filter'])->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth(12)->setYear($params['year_filter'])->endOfMonth()->toDateString();
        // dd($firstdate);

        $bikesreportList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','bike_histories.total_pay','bike_histories.saved_at')
        ->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('bike_histories')->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.bikereportView.yearlyindex',compact('bikesreportList','sumreport'));
    }
}
