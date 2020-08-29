<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BikeQueues;
use App\Bikes;
use App\Washtypes;
use App\Workers;
use Carbon\Carbon;

class BikequeueController extends Controller
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
        ->select('bike_queues.id','bike_queues.queue_number','bike_queues.status','bike_queues.estimation_time','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','workers.name','wash_type.wash_type')
        ->where('bike_queues.booking_date', '<=',Carbon::now('Asia/Jakarta')->toDateString())
        ->orderby('id','asc')->get();
        // dd(Carbon::now('Asia/Jakarta')->toDateString());
        return view('admin.bikequeueView.index',compact('bikequeuesList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkAntrian = BikeQueues::where('booking_date', '=',Carbon::now('Asia/Jakarta')->toDateString())->count();
        if($checkAntrian < 15){
            $workerList= Workers::all();
            return view('admin.bikequeueView.create',compact('workerList'));
        }else{
            return redirect()->route('bikequeue.index')->with('status','Antrian Hari Ini Penuh,Silahkan Antri di Hari Berikutnya Pada Menu Booking');
        }
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
            'estimation_time_hour' => 'numeric',
            'estimation_time_minute' => 'numeric',
            'status' => 'required',
            'worker_name' => 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'worker_name.required' => 'Nama pekerja tidak boleh kosong!',
            'wash_type.required' => 'Jenis cuci tidak boleh kosong!',
            'estimation_time_hour.numeric' => 'Estimasi Waktu(Jam) harus angka!',
            'estimation_time_minute.numeric' => 'Estimasi Waktu(Menit) harus angka!',
            'status.required' => 'Status pekerjaan tidak boleh kosong!',
        ]);

        $bikequeueform=$request->except('_token','updated_at','created_at');

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

        //ambil data pegawai
        $workerData = Workers::select('id')
            ->where('name', '=', $bikequeueData['worker_name'])
            ->get()->toArray();

        //passing worker_id ke array baru   
        $workerData = ["worker_id"=>$workerData[0]['id']];
        //gabung array baru dengan array antrian
        $bikequeueData = array_merge($bikequeueData,$workerData);

        //gabungkan estimasi waktu
        if($bikequeueData['estimation_time_hour'] != null || $bikequeueData['estimation_time_minute'] != null){
            $estimation_time = ['estimation_time'=>Carbon::createFromTime($bikequeueData['estimation_time_hour'], $bikequeueData['estimation_time_minute'])
            ->toTimeString(),'booking_date'=>Carbon::now('Asia/Jakarta')->toDateString()];
        }else{
            $estimation_time = ['estimation_time'=>Carbon::now('Asia/Jakarta')->addMinutes(45)->toTimeString(),'booking_date'=>Carbon::now('Asia/Jakarta')->toDateString()];
        }
        $bikequeueData = array_merge($bikequeueData,$estimation_time);
        
        $sumQueue= DB::table('bike_queues')->where('booking_date','=',$bikequeueData['booking_date'])->count();
                        
        if($sumQueue == 0){
            $queueNumber = ['queue_number'=>1];
            $bikequeueData = array_merge($bikequeueData,$queueNumber);
        }else{
            $sumQueue= DB::table('bike_queues')->select('queue_number')->where('booking_date','=',$bikequeueData['booking_date'])->orderby('queue_number','desc')->first();
            $convertSum= $sumQueue->queue_number;
            $queueNumber = ['queue_number'=>$convertSum+1];
            $bikequeueData = array_merge($bikequeueData,$queueNumber);
        }
        
        //menghapus data yang tidak diperlukan
        unset($bikequeueData['license_plate'],$bikequeueData['wash_type'],$bikequeueData['worker_name'],$bikequeueData['estimation_time_hour'],$bikequeueData['estimation_time_minute']);

        // dd($bikequeueData);

        $saved = BikeQueues::create($bikequeueData);
        return redirect()->route('bikequeue.index');
        // dd($bikequeueData);
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
        ->select('bike_queues.id','bike_queues.status','bike_queues.estimation_time','bikes.license_plate','workers.name as worker_name','wash_type.wash_type')
        ->where('bike_queues.id','=',$id)->get()->toArray();

        //split waktu
        $estimation_time = explode(':',$bikequeuesFind[0]->estimation_time);
        //hapus seperdetik
        unset($estimation_time['2']);
        //ganti nama key dalam array
        $estimation_time = ['estimation_time_hour'=>$estimation_time['0'],'estimation_time_minute'=>$estimation_time['1']];
        //casting multidimentional array ke single dimentional array
        $bikequeueData = (array) $bikequeuesFind[0];
        //gabung array estimasi waktu splited dengan array data
        $bikequeueData = array_merge($bikequeueData,$estimation_time);
        //hapus waktu yang digabung pada array
        unset($bikequeueData['estimation_time']);
        // dd($bikequeueData);
        
        $workerList= Workers::all();
        $status[0]=["status"=>"dalam antrian","name"=>"Dalam Antrian"];
        $status[1]=["status"=>"proses","name"=>"Proses"];
        $status[2]=["status"=>"selesai","name"=>"Selesai"];
        return view('admin.bikequeueView.edit',compact('bikequeueData','workerList','status'));
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
            'worker_name' => 'required',
            'wash_type' => 'required',
            'estimation_time_hour' => 'numeric',
            'estimation_time_minute' => 'numeric',
            'status' => 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'worker_name.required' => 'Nama pekerja tidak boleh kosong!',
            'wash_type.required' => 'Jenis cuci tidak boleh kosong!',
            'estimation_time_hour.numeric' => 'Estimasi Waktu(Jam) tidak boleh kosong!',
            'estimation_time_minute.numeric' => 'Estimasi Waktu(Menit) tidak boleh kosong!',
            'status.required' => 'Status pekerjaan tidak boleh kosong!',
        ]);

        $bikequeueform=$request->except('_token','updated_at','created_at');

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

        //ambil data pegawai
        $workerData = Workers::select('id')
            ->where('name', '=', $bikequeueData['worker_name'])
            ->get()->toArray();

        //passing worker_id ke array baru   
        $workerData = ["worker_id"=>$workerData[0]['id']];
        //gabung array baru dengan array antrian
        $bikequeueData = array_merge($bikequeueData,$workerData);

        //gabungkan estimasi waktu
        if($bikequeueData['estimation_time_hour'] != null || $bikequeueData['estimation_time_minute'] != null){
            $estimation_time = ['estimation_time'=>Carbon::createFromTime($bikequeueData['estimation_time_hour'], $bikequeueData['estimation_time_minute'])
            ->toTimeString()];
        }else{
            $estimation_time = ['estimation_time'=>Carbon::now()->addMinutes(45)->toTimeString()];
        }
        $bikequeueData = array_merge($bikequeueData,$estimation_time);

        //menghapus data yang tidak diperlukan
        unset($bikequeueData['license_plate'],$bikequeueData['wash_type'],$bikequeueData['worker_name'],$bikequeueData['estimation_time_hour'],$bikequeueData['estimation_time_minute']);

        // dd($bikequeueData);
        $bikesUpdate = BikeQueues::whereId($id)->update($bikequeueData);
        return redirect()->route('bikequeue.index');
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
        return redirect()->route('bikequeue.index');
    }
}
