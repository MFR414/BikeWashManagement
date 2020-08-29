<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CarpetreportController extends Controller
{
    public function dailyIndex(){
        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->where('carpet_histories.saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('id','asc')->get();
        // dd($carpetsreportList);

        $sumreport=DB::table('carpet_histories')->where('saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())->sum('total_pay');

        // dd($sumreport);

        $dayStrict=['min_date'=>Carbon::now()->firstOfMonth()->toDateString(),'max_date'=>Carbon::now()->lastOfMonth()->toDateString()];
        return view('admin.carpetreportView.dailyindex',compact('carpetsreportList','dayStrict','sumreport'));
    }

    public function dailyIndexByDate(Request $request){
        $date=$request->except('_token','updated_at','created_at');
        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->where('carpet_histories.saved_at','=',$date['date_filter'])
        ->orderby('id','asc')->get();
        // dd($bikeshistoriesList);

        $sumreport=DB::table('carpet_histories')->where('saved_at','=',$date['date_filter'])->sum('total_pay');

        $dayStrict=['min_date'=>Carbon::now()->firstOfMonth()->toDateString(),'max_date'=>Carbon::now()->lastOfMonth()->toDateString()];
        return view('admin.carpetreportView.dailyindex',compact('carpetsreportList','dayStrict','sumreport'));
    }

    public function monthlyIndex(){
        $firstdate = Carbon::now('Asia/Jakarta')->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->endOfMonth()->toDateString();

        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('carpet_histories')->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.carpetreportView.monthlyindex',compact('carpetsreportList','sumreport'));
    }
    public function monthlyIndexByDate(Request $request){
        $params = $request->except('_token','updated_at','created_at');
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth($params['month_filter'])->setYear($params['year_filter'])->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth($params['month_filter'])->setYear($params['year_filter'])->endOfMonth()->toDateString();
        // dd($firstdate);

        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('carpet_histories')->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.carpetreportView.monthlyindex',compact('carpetsreportList','sumreport'));
    }

    public function yearlyIndex(){
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth(01)->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth(12)->endOfMonth()->toDateString();

        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('carpet_histories')->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.carpetreportView.yearlyindex',compact('carpetsreportList','sumreport'));
    }

    public function yearlyIndexByDate(Request $request){
        $params = $request->except('_token','updated_at','created_at');
        $firstdate = Carbon::now('Asia/Jakarta')->setMonth(01)->setYear($params['year_filter'])->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->setMonth(12)->setYear($params['year_filter'])->endOfMonth()->toDateString();
        // dd($firstdate);

        $carpetsreportList= DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','carpet_histories.type_of_payment','carpet_histories.total_pay','carpet_histories.saved_at')
        ->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])
        ->orderby('id','asc')->get();
        // dd($bikesreportList);

        $sumreport=DB::table('carpet_histories')->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        // dd($sumreport);
        return view('admin.carpetreportView.yearlyindex',compact('carpetsreportList','sumreport'));
    }
}
