<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Carpets;
use App\Customers;

class APICarpetController extends Controller
{
    public function index(){
        $carpets = DB::table('carpets')
        ->join('customers', 'carpets.customer_id', '=', 'customers.id')
        ->select('carpets.id','carpets.color_of_carpet','carpets.type_of_carpet','carpets.length_of_carpets','carpets.width_of_carpets','carpets.amount_of_wash','carpets.note', 'customers.name as customer_name')
        ->get()->toArray();
        return response()->json($carpets, 200);
    }

    public function show($id){
        $carpets = DB::table('carpets')
        ->join('customers', 'carpets.customer_id', '=', 'customers.id')
        ->select('carpets.id','carpets.color_of_carpet','carpets.type_of_carpet','carpets.length_of_carpets','carpets.width_of_carpets','carpets.amount_of_wash','carpets.note', 'customers.name as customer_name')
        ->where('carpets.id','=',$id)
        ->get()->toArray();
        //casting multidimentional array ke single dimentional array
        $carpets = (array) $carpets[0];
        if (is_null($carpets)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($carpets, 200);
        }
    }

    public function store(Request $request){
        $carpets = $request->all();
        $validator= Validator::make($carpets,[
            'color_of_carpet' => 'required',
            'type_of_carpet' => 'required',
            'length_of_carpets' => 'required',
            'width_of_carpets' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }
        
        $carpetData = Customers::select('id')
            ->where('name', '=', $carpets['customer_name'])
            ->get()->toArray();
        //passing worker_id ke array baru   
        $customerData = ["customer_id"=>$carpetData[0]['id']];
        
        $carpetCheck = DB::table('carpets')
        ->join('customers', 'carpets.customer_id', '=', 'customers.id')
        ->select('carpets.id','carpets.color_of_carpet','carpets.type_of_carpet','carpets.length_of_carpets','carpets.width_of_carpets','carpets.amount_of_wash','carpets.note', 'customers.name as customer_name')
        ->where('carpets.color_of_carpet','=',$carpets['color_of_carpet'])
        ->where('carpets.type_of_carpet','=',$carpets['type_of_carpet'])
        ->where('carpets.customer_id','=',$customerData['customer_id'])
        ->get();
        
        if($carpetCheck->count() == 0){
            //gabung array baru dengan array form
            $carpets = array_merge($carpets,$customerData);
            //menghapus data yang tidak diperlukan
            unset($carpets['customer_name']);
            $carpets = Carpets::create($carpets);
            return response()->json('success', 201);
        }else{
            return response()->json([
                'message' => 'Data Already Exist!'
            ],409);
        }
        
    }

    public function update(Request $request,$id){
        $carpets  =  Carpets::find($id);
        if(!$carpets){
            return $this->notFound('Carpet not found !');
        }
    
        $updates=$request->all();

        $validator= Validator::make($updates,[
            'color_of_carpet' => 'required',
            'type_of_carpet' => 'required',
            'length_of_carpets' => 'required',
            'width_of_carpets' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }

        $carpetData = Customers::select('id')
            ->where('name', '=', $updates['customer_name'])
            ->get()->toArray();   
         //passing customer_id ke array baru   
         $customerData = ["customer_id"=>$carpetData[0]['id']];
         ////gabung array baru dengan array form
         $carpetData = array_merge($updates,$customerData);
         //menghapus data yang tidak diperlukan
         unset($carpetData['customer_name']);
        $carpetsUpdate = $carpets->update($carpetData);
        return response()->json($carpetData, 200);
    }

    public function destroy($id){
        Carpets::find($id)->delete();
        return response()->json('success', 200);
    }
    
    public function searchCarpetCustomer($id){
        $customers = Carpets::where('customer_id','=',$id)
            ->get();
        if (is_null($customers)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($customers, 200);
        }
    }
}
