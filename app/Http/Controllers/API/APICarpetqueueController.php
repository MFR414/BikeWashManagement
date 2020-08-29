<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Carpets;
use App\Customers;
use App\Washtypes;
use App\CarpetQueues;

class APICarpetqueueController extends Controller
{
    public function index(){
        $carpets = DB::table('carpet_queues')
        ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
        ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
        ->select('carpet_queues.id','carpet_queues.status','carpet_queues.estimation_time','customers.name as customer','carpets.color_of_carpet','carpets.type_of_carpet','wash_type.wash_type')
        ->orderby('id','asc')->get();
        return response()->json($carpets, 200);
    }

    public function show($id){
        $carpets=DB::table('carpet_queues')
        ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
        ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
        ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
        ->select('carpet_queues.id','carpet_queues.status','carpet_queues.estimation_time','customers.name as customer','carpets.color_of_carpet','carpets.type_of_carpet','wash_type.wash_type')
        ->where('carpet_queues.id','=',$id)
        ->get();
       
        if (is_null($carpets)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpets, 200);
        }
    }

    public function store(Request $request){
        $updates = $request->all();
        $validator= Validator::make($updates,[
            'color_of_carpet' => 'required',
            'type_of_carpet' => 'required',
            'wash_type' => 'required',
            'customer_name' => 'required',
            'booking_date' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }
        
        $bookingDateCheck = Carbon::parse($updates['booking_date'])->format('l');
        if($updates['booking_date'] >= Carbon::now('Asia/Jakarta')->toDateString()){
            if($bookingDateCheck != 'Friday'){
                //ambil id customer dari database
                $customerDataFind = Customers::select('id')
                    ->where('name', '=', $updates['customer_name'])->get()->toArray();
        
                $customerData = ["customer_id"=>$customerDataFind[0]['id']];
                $carpetqueueData = array_merge($updates,$customerData);
                
                $carpetqueueCheck = CarpetQueues::where('carpet_queues.customer_id','=',$carpetqueueData['customer_id'])
                ->get();
                
                if($carpetqueueCheck->count() == 0){
                    //ambil id karpet dan id customer dari database
                    $carpetDataFind = Carpets::select('id')
                        ->where([['color_of_carpet', '=', $carpetqueueData['color_of_carpet']],
                                ['type_of_carpet', '=', $carpetqueueData['type_of_carpet']],
                                ['customer_id', '=', $carpetqueueData['customer_id']]])
                        ->get()->toArray();
                    
                    //passing carpet_id dan customer_id ke array baru
                    $carpetData = ["carpet_id"=>$carpetDataFind[0]['id']];
                    //gabung array baru dengan array antrian
                    $carpetqueueData = array_merge($carpetqueueData,$carpetData);
                    
                    //ambil data jenis cuci
                    $washtypeData= Washtypes::select('id')
                        ->where([['wash_type', '=', $updates['wash_type']],['type_of_carpets', '=', $updates['type_of_carpet']]])
                        ->get()->toArray();
            
                    //passing carpet_id dan customer_id ke array baru
                    $washtypeData = ["washtype_id"=>$washtypeData[0]['id']];
                    //gabung array baru dengan array antrian
                    $carpetqueueData = array_merge($carpetqueueData,$washtypeData);
            
                    //passing worker_id ke array baru   
                    $workerData = ["worker1_id"=>null,"worker2_id"=>null,"status"=>"dalam antrian"];
                   
                    //gabung array baru dengan array antrian
                    $carpetqueueData = array_merge($carpetqueueData,$workerData);
            
                    // $estimation_time = ['estimation_time'=>Carbon::createFromTime(0, 0, 0, 'Asia/Jakarta')->toTimeString(),'booking_date'=>$updates['booking_date']];
                    // $carpetqueueData = array_merge($carpetqueueData,$estimation_time);
                    
                    $sumQueue= CarpetQueues::where('booking_date', '=',$updates['booking_date'])->count();
                        
                    if($sumQueue > 0){
                        $sumQueue= CarpetQueues::select('queue_number')->where('booking_date', '=',$updates['booking_date'])->orderby('queue_number','desc')->first();
                        $convertSum= $sumQueue->queue_number;
                        $queueNumber = ['queue_number'=>$convertSum+1];
                        $carpetqueueData = array_merge($carpetqueueData,$queueNumber);
                    }else{
                        $queueNumber = ['queue_number'=>1];
                        $carpetqueueData = array_merge($carpetqueueData,$queueNumber);
                    }
            
                    //menghapus data yang tidak diperlukan
                    unset($carpetqueueData['color_of_carpet'],$carpetqueueData['type_of_carpet'],$carpetqueueData['customer_name'],$carpetqueueData['wash_type']);
                    $saved = CarpetQueues::create($carpetqueueData);
            
                    return response()->json('success', 201);
                    // return response()->json($carpetqueueData, 200);
                     
                }else{
                    return response()->json([
                        'message' => 'Your Other Queues Are Still On List!'
                    ],409);
                    // return response()->json($carpetCheck, 200);
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
        Carpetqueues::find($id)->delete();
        return response()->json('success', 200);
    }
}
