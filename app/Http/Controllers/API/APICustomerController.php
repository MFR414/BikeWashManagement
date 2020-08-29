<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Customers;

class APICustomerController extends Controller
{
    public function index(){
        $customers = Customers::all();
        return response()->json($customers, 200);
    }

    public function show($id){
        $customers = Customers::find($id);
        if (is_null($customers)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($customers, 200);
        }
    }

    public function register(Request $request){
        $customers = $request->all();
        $validator= Validator::make($customers,[
            'username'=>['required','min:5'],
            'password'=>['required','min:5'],
            'name'=>['required'],
            'address'=>['required'],
            'phone_number'=>['required','numeric'],
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=> $validator->messages()
            ], 400);
        }
        $customers = Customers::create($customers);
        return response()->json('success', 201);
    }

    public function update(Request $request,Customers $customers){
        $customers->update($request->all());
        return response()->json($customers, 200);
    }
    
    public function loginCustomer(Request $request){
        $customers = Customers::where('username','=',$request->username)
            ->where('password','=',$request->password)->first();
        if (is_null($customers)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($customers, 200);
        }
    }

    public function destroy(Customers $customers){
        $customers->delete();
        return response()->json('success', 200);
    }
}
