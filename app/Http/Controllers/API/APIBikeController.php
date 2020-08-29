<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Bikes;
use App\Customers;

class APIBikeController extends Controller
{
    public function index(){
        $bikes = DB::table('bikes')
        ->join('customers', 'bikes.customer_id', '=', 'customers.id')
        ->select('bikes.id','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','bikes.amount_of_wash','bikes.note', 'customers.name as customer_name')
        ->get();
        return response()->json($bikes, 200);
    }

    public function show($id){
        $bikes = DB::table('bikes')
        ->join('customers', 'bikes.customer_id', '=', 'customers.id')
        ->select('bikes.id','bikes.license_plate','bikes.type_of_bike','bikes.size_of_bike','bikes.amount_of_wash','bikes.note', 'customers.name as customer_name')
        ->where('bikes.id','=',$id)
        ->get();
        //casting multidimentional array ke single dimentional array
        $bikes = (array) $bikes[0];
        if (is_null($bikes)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikes, 200);
        }
    }

    public function store(Request $request){
        $bikes = $request->all();
        $validator= Validator::make($bikes,[
            'license_plate' => 'required',
            'type_of_bike' => 'required',
            'size_of_bike' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }
        
        $bikeCheck= Bikes::where('bikes.license_plate','=',$bikes['license_plate'])
        ->get();
        
        if($bikeCheck->count() == 0){
            $bikesData = Customers::select('id')
            ->where('name', '=', $bikes['customer_name'])
            ->get()->toArray();
            //passing customer_id ke array baru   
            $customerData = ["customer_id"=>$bikesData[0]['id']];
            //gabung array baru dengan array form
            $bikes = array_merge($bikes,$customerData);
            //menghapus data yang tidak diperlukan
            unset($bikes['customer_name']);
            $bikes = Bikes::create($bikes);
            return response()->json('success', 201);
        }else{
            return response()->json([
                'message' => 'Data Already Exist!'
            ],409);
        }
    }

    public function update(Request $request,$id){
        $bikes  =  Bikes::find($id);
        if(!$bikes){
            return $this->notFound('bikes not found !');
        }
    
        $updates=$request->all();

        $validator= Validator::make($updates,[
            'license_plate' => 'required',
            'type_of_bike' => 'required',
            'size_of_bike' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }

        $bikesData = Customers::select('id')
            ->where('name', '=', $updates['customer_name'])
            ->get()->toArray();

        //passing customer_id ke array baru   
        $customerData = ["customer_id"=>$bikesData[0]['id']];
        ////gabung array baru dengan array form
        $bikesData = array_merge($updates,$customerData);
        //menghapus data yang tidak diperlukan
        unset($bikesData['customer_name']);
        $bikesUpdate = $bikes->update($bikesData);
        return response()->json($bikesData, 200);
    }

    public function destroy($id){
        Bikes::find($id)->delete();
        return response()->json('success', 200);
    }
    
    public function searchBikeCustomer($id){
        $bikes = Bikes::where('customer_id','=',$id)->get();
        if (is_null($bikes)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($bikes, 200);
        }
    }
}
