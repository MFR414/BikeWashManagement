<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**

     * Show the application admin dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()

    {
        $bikequeuesCount= DB::table('bike_queues')
        ->where('booking_date','<=',Carbon::now('Asia/Jakarta')->toDateString())
        ->get()->count();

        $bikebookingCount= DB::table('bike_queues')
        ->where('booking_date','>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get()->count();

        $bikeTodayEarnings=DB::table('bike_histories')->where('saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())->sum('total_pay');

        $firstdate = Carbon::now('Asia/Jakarta')->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->endOfMonth()->toDateString();
        $bikeThisMonthEarnings=DB::table('bike_histories')->whereBetween('bike_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        $bikeData = ['queues_count'=>$bikequeuesCount,'booking_count'=>$bikebookingCount,'today_earnings'=>$bikeTodayEarnings,'this_month_earnings'=>$bikeThisMonthEarnings];

        $carpetqueuesCount= DB::table('carpet_queues')
        ->where('booking_date','<=',Carbon::now('Asia/Jakarta')->toDateString())
        ->get()->count();

        $carpetbookingCount= DB::table('carpet_queues')
        ->where('booking_date','>',Carbon::now('Asia/Jakarta')->toDateString())
        ->get()->count();

        $carpetTodayEarnings=DB::table('carpet_histories')->where('saved_at','=',Carbon::now('Asia/Jakarta')->toDateString())->sum('total_pay');

        $firstdate = Carbon::now('Asia/Jakarta')->firstOfMonth()->toDateString();
        $lastdate = Carbon::now('Asia/Jakarta')->endOfMonth()->toDateString();
        $carpetThisMonthEarnings=DB::table('carpet_histories')->whereBetween('carpet_histories.saved_at',[$firstdate,$lastdate])->sum('total_pay');

        $carpetData = ['queues_count'=>$carpetqueuesCount,'booking_count'=>$carpetbookingCount,'today_earnings'=>$carpetTodayEarnings,'this_month_earnings'=>$carpetThisMonthEarnings];

        // dd($bikeData);
        return view('admin.home',compact('bikeData','carpetData'));
    }

  

    /**

     * Show the application owner dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function ownerHome()

    {

        return view('owner.home');

    }
}
