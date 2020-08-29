<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BikeQueues;
use App\Bikes;
use App\Washtypes;
use App\Workers;
use Carbon\Carbon;

class BikebookingController extends Controller
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
        ->leftjoin('workers', 'bike_queues.worker_id', '=', 'workers.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.queue_number','bike_queues.status','bike_queues.booking_date','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','workers.name','wash_type.wash_type')
        ->where('bike_queues.booking_date', '>',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('booking_date','asc')->get();
        // dd(Carbon::now('Asia/Jakarta')->toDateString());
        return view('admin.bikebookingView.index',compact('bikequeuesList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $workerList= Workers::all();
        return view('admin.bikebookingView.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'license_plate' => 'required',
            'wash_type' => 'required',
            'booking_date'=> 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'wash_type.required' => 'Jenis cuci tidak boleh kosong!',
            'booking_date.required' => 'Tanggal booking tidak boleh kosong',
        ]);
        $bikequeueform=$request->except('_token','updated_at','created_at');

        $checkAntrian = BikeQueues::where('booking_date', '=',$bikequeueform['booking_date'])->count();
        $bookingDateCheck = Carbon::parse($bikequeueform['booking_date'])->format('l');
        if($bookingDateCheck != 'Friday'){
            if($checkAntrian < 15){
                //ambil data motor dari database
                $bikeData = Bikes::select('id','customer_id','type_of_bike','size_of_bike')
                    ->where('license_plate', '=', $bikequeueform['license_plate'])
                    ->get()->toArray();
                
                //parameter penentu jenis cuci
                $washtypeParam = ["type_of_bike"=>$bikeData[0]['type_of_bike'],"size_of_bike"=>$bikeData[0]['size_of_bike'],"wash_type"=>$bikequeueform['wash_type']];
                
                //passing bike_id dan customer_id ke array baru
                $bikeData = ["customer_id"=>$bikeData[0]['customer_id'],"bike_id"=>$bikeData[0]['id']];
                //gabung array baru dengan array antrian
                $bikequeueData = array_merge($bikequeueform,$bikeData);
                
                //ambil data jenis cuci
                $washtypeData= Washtypes::select('id')
                    ->where('wash_type', '=', $washtypeParam['wash_type'])
                    ->where('type_of_bike', '=', $washtypeParam['type_of_bike'])
                    ->where('size_of_bike', '=', $washtypeParam['size_of_bike'])
                    ->get()->toArray();
    
                //passing bike_id dan customer_id ke array baru
                $washtypeData = ["washtype_id"=>$washtypeData[0]['id']];
                //gabung array baru dengan array antrian
                $bikequeueData = array_merge($bikequeueData,$washtypeData);
    
                // //ambil data pegawai
                // $workerData = Workers::select('id')
                //     ->where('name', '=', $bikequeueData['worker_name'])
                //     ->get()->toArray();
    
                // //passing worker_id ke array baru   
                // $workerData = ["worker_id"=>$workerData[0]['id']];
                // //gabung array baru dengan array antrian
                // $bikequeueData = array_merge($bikequeueData,$workerData);
    
                $estimation_time = ['estimation_time'=>Carbon::createFromTime(0, 0, 0, 'Asia/Jakarta')->toTimeString(),'status'=>'dalam antrian'];
                $bikequeueData = array_merge($bikequeueData,$estimation_time);
                
                $sumQueue= DB::table('bike_queues')->where('booking_date','=',$bikequeueform['booking_date'])->count();
                        
                if($sumQueue > 0){
                    $sumQueue= DB::table('bike_queues')->select('queue_number')->where('booking_date','=',$bikequeueform['booking_date'])->orderby('queue_number','desc')->first();
                    $convertSum= $sumQueue->queue_number;
                    $queueNumber = ['queue_number'=>$convertSum+1];
                    $bikequeueData = array_merge($bikequeueData,$queueNumber);
                }else{
                    $queueNumber = ['queue_number'=>1];
                    $bikequeueData = array_merge($bikequeueData,$queueNumber);
                }
    
                //menghapus data yang tidak diperlukan
                unset($bikequeueData['license_plate'],$bikequeueData['wash_type']);
    
                $saved = BikeQueues::create($bikequeueData);
                return redirect()->route('bikebooking.index');
            }else{
                return redirect()->route('bikebooking.index')->with('status','Antrian pada hari '.$bikequeueform['booking_date'].' Penuh. Silahkan Antri di Hari Berikutnya Pada Menu Booking');
            }
        }else{
            return redirect()->route('bikebooking.index')->with('status','Maaf, Kami libur Pada hari jumat ');
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bikequeuesFind= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->leftjoin('workers', 'bike_queues.worker_id', '=', 'workers.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.booking_date','bike_queues.status','bikes.license_plate','wash_type.wash_type')
        ->where('bike_queues.id','=',$id)->get()->toArray();

        // //split waktu
        // $estimation_time = explode(':',$bikequeuesFind[0]->estimation_time);
        // //hapus seperdetik
        // unset($estimation_time['2']);
        // //ganti nama key dalam array
        // $estimation_time = ['estimation_time_hour'=>$estimation_time['0'],'estimation_time_minute'=>$estimation_time['1']];
        //casting multidimentional array ke single dimentional array
        $bikequeueData = (array) $bikequeuesFind[0];
        // //gabung array estimasi waktu splited dengan array data
        // $bikequeueData = array_merge($bikequeueData,$estimation_time);
        // //hapus waktu yang digabung pada array
        // unset($bikequeueData['estimation_time']);
        // // dd($bikequeueData);
        
        return view('admin.bikebookingView.edit',compact('bikequeueData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'license_plate' => 'required',
            'wash_type' => 'required',
            'booking_date'=> 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'wash_type.required' => 'Jenis cuci tidak boleh kosong!',
            'booking_date.required' => 'Tanggal booking tidak boleh kosong',
        ]);

        $bikequeueform=$request->except('_token','updated_at','created_at');

        $checkAntrian = BikeQueues::where('booking_date', '=',$bikequeueform['booking_date'])->count();
        $bookingDateCheck = Carbon::parse($bikequeueform['booking_date'])->format('l');
        if($bookingDateCheck != 'Friday'){
            if($checkAntrian < 15){
                //ambil data motor dari database
                $bikeData = Bikes::select('id','customer_id','type_of_bike','size_of_bike')
                    ->where('license_plate', '=', $bikequeueform['license_plate'])
                    ->get()->toArray();
                
                //parameter penentu jenis cuci
                $washtypeParam = ["type_of_bike"=>$bikeData[0]['type_of_bike'],"size_of_bike"=>$bikeData[0]['size_of_bike'],"wash_type"=>$bikequeueform['wash_type']];
                
                //passing bike_id dan customer_id ke array baru
                $bikeData = ["customer_id"=>$bikeData[0]['customer_id'],"bike_id"=>$bikeData[0]['id']];
                //gabung array baru dengan array antrian
                $bikequeueData = array_merge($bikequeueform,$bikeData);
                
                //ambil data jenis cuci
                $washtypeData= Washtypes::select('id')
                    ->where('wash_type', '=', $washtypeParam['wash_type'])
                    ->where('type_of_bike', '=', $washtypeParam['type_of_bike'])
                    ->where('size_of_bike', '=', $washtypeParam['size_of_bike'])
                    ->get()->toArray();
    
                //passing bike_id dan customer_id ke array baru
                $washtypeData = ["washtype_id"=>$washtypeData[0]['id']];
                //gabung array baru dengan array antrian
                $bikequeueData = array_merge($bikequeueData,$washtypeData);
    
                // //ambil data pegawai
                // $workerData = Workers::select('id')
                //     ->where('name', '=', $bikequeueData['worker_name'])
                //     ->get()->toArray();
    
                // //passing worker_id ke array baru   
                // $workerData = ["worker_id"=>$workerData[0]['id']];
                // //gabung array baru dengan array antrian
                // $bikequeueData = array_merge($bikequeueData,$workerData);
    
                $estimation_time = ['estimation_time'=>Carbon::createFromTime(0, 0, 0, 'Asia/Jakarta')->toTimeString(),'status'=>'dalam antrian'];
                $bikequeueData = array_merge($bikequeueData,$estimation_time);
                
                $sumQueue= DB::table('bike_queues')->where('booking_date','=',$bikequeueform['booking_date'])->count();
                        
                if($sumQueue == 0){
                    $queueNumber = ['queue_number'=>1];
                    $bikequeueData = array_merge($bikequeueData,$queueNumber);
                }else{
                    $sumQueue= DB::table('bike_queues')->select('queue_number')->where('booking_date','=',$bikequeueform['booking_date'])->orderby('queue_number','desc')->first();
                    $convertSum= $sumQueue->queue_number;
                    $queueNumber = ['queue_number'=>$convertSum+1];
                    $bikequeueData = array_merge($bikequeueData,$queueNumber);
                }
    
                //menghapus data yang tidak diperlukan
                unset($bikequeueData['license_plate'],$bikequeueData['wash_type']);

                $bikesUpdate = BikeQueues::whereId($id)->update($bikequeueData);
                return redirect()->route('bikebooking.index');
            }else{
                return redirect()->route('bikebooking.index')->with('status','Antrian pada hari '.$bikequeueform['booking_date'].' Penuh. Silahkan Antri di Hari Berikutnya Pada Menu Booking');
            }
        }else{
            return redirect()->route('bikebooking.index')->with('status','Maaf, Kami libur Pada hari jumat ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BikeQueues::find($id)->delete();
        return redirect()->route('bikebooking.index');
    }
}
