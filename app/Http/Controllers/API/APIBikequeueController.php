<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Bikes;
use App\Customers;
use App\Washtypes;
use App\BikeQueues;

class APIBikequeueController extends Controller
{
    public function index(){
        $bikequeuesList= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.queue_number','bike_queues.status','bike_queues.estimation_time','customers.name as customer','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','wash_type.wash_type')
        ->where('bike_queues.booking_date','=',Carbon::now()->toDateString())
        ->orderby('id','asc')->get();
        return response()->json($bikequeuesList, 200);
    }

    public function show($id){
        $bikequeuesList= DB::table('bike_queues')
        ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
        ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
        ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
        ->select('bike_queues.id','bike_queues.queue_number','bike_queues.status','bike_queues.estimation_time','customers.name as customer','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','wash_type.wash_type')
        ->where('bike_queues.id','=',$id)
        ->get();
       
        if(is_null($bikequeuesList)) {
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
        ->select('bike_queues.id','bike_queues.queue_number','bike_queues.status','bike_queues.estimation_time','customers.name as customer','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','wash_type.wash_type')
        ->where('bike_queues.customer_id','=',$id)
        ->get();
       
        if(is_null($bikequeuesList)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikequeuesList, 200);
        }
    }

    public function store(Request $request){
        $makes = $request->all();
        $validator= Validator::make($makes,[
            'license_plate' => 'required',
            'wash_type' => 'required',
            'booking_date' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }
        
        $checkAntrian = BikeQueues::where('booking_date', '=',$makes['booking_date'])->count();
        $bookingDateCheck = Carbon::parse($makes['booking_date'])->format('l');
        if($makes['booking_date'] >= Carbon::now('Asia/Jakarta')->toDateString()){
            if($bookingDateCheck != 'Friday'){
                if($checkAntrian < 15){
                    //ambil data motor dari database
                    $customerData = Bikes::select('customer_id')
                    ->where('license_plate', '=', $makes['license_plate'])
                    ->get()->toArray();
                    
                    $bikequeueCheck = BikeQueues::where('bike_queues.customer_id','=',$customerData[0]['customer_id'])
                    ->get();
                    
                    if($bikequeueCheck->count() == 0){
                        //ambil data motor dari database
                        $bikeData = Bikes::select('id','customer_id','type_of_bike','size_of_bike')
                        ->where('license_plate', '=', $makes['license_plate'])
                        ->get()->toArray();
                   
                        //parameter penentu jenis cuci
                        $washtypeParam = ["type_of_bike"=>$bikeData[0]['type_of_bike'],"size_of_bike"=>$bikeData[0]['size_of_bike'],"wash_type"=>$makes['wash_type']];
                        
                        //passing bike_id dan customer_id ke array baru
                        $bikeData = ["customer_id"=>$bikeData[0]['customer_id'],"bike_id"=>$bikeData[0]['id'],"booking_date"=>$makes['booking_date']];
                        //gabung array baru dengan array antrian
                        $bikequeueData = array_merge($makes,$bikeData);
                        
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
                
                        //passing worker_id ke array baru   
                        $workerData = ["worker_id"=>null,"status"=>"dalam antrian"];
                        
                        //gabung array baru dengan array antrian
                        $bikequeueData = array_merge($bikequeueData,$workerData);
                
                        $estimation_time = ['estimation_time'=>Carbon::createFromTime(0, 0, 0, 'Asia/Jakarta')->toTimeString()];
                        $bikequeueData = array_merge($bikequeueData,$estimation_time);
                        
                        $sumQueue= DB::table('bike_queues')->where('booking_date','=',$makes['booking_date'])->count();
                        
                        if($sumQueue > 0){
                            $sumQueue= DB::table('bike_queues')->select('queue_number')->where('booking_date','=',$makes['booking_date'])->orderby('queue_number','desc')->first();
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
                        return response()->json('success', 201);
                        // return response()->json($bikequeueData, 200);
                    }else{
                        return response()->json([
                            'message' => 'Your Other Queues Are Still On List!'
                        ],409);
                    }
                }else{
                    return response()->json([
                        'message' => 'Antrian pada hari '.$makes['booking_date'].' Penuh. Silahkan Antri di Hari Berikutnya Pada Menu Booking'
                    ],409);
                }
            }else{
                return response()->json([
                    'message' => 'Maaf, Kami libur Pada hari jumat'
                ],409);
            }
        }else{
            return response()->json([
                'message' => 'Maaf, Anda tidak bisa booking pada tanggal lampau'
            ],409);
        }
    }

    public function update(Request $request,$id){
       //
    }

    public function destroy($id){
        Bikequeues::find($id)->delete();
        return response()->json('success', 200);
    }
}
