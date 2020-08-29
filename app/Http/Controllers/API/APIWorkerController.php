<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Workers;
use App\Http\Controllers\Controller;

class APIWorkerController extends Controller
{
    public function index(){
        $workers = Workers::all();
        return response()->json($workers, 200);
    }

    public function show($id){
        $workers = Workers::find($id);
        if (is_null($workers)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($workers, 200);
        }
    }

    public function register(Request $request){
        $workers = $request->all();
        $validator= Validator::make($workers,[
            'username'=>['required','min:5'],
            'password'=>['required','min:5'],
            'name'=>['required'],
            'address'=>['required'],
            'phone_number'=>['required','numeric'],
        ]);
        $workers = Workers::create($workers);
        return response()->json('success', 201);
    }

    public function update(Request $request,Workers $workers){
        $workers = $request->all();
        $workers->update($request->all());
        return response()->json($workers, 200);
    }
    
    public function loginWorker(Request $request){
        $workers = Workers::where('username','=',$request->username)
            ->where('password','=',$request->password)->first();
        if (is_null($workers)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($workers, 200);
        }
    }

    public function destroy(Workers $workers){
        $workers->delete();
        return response()->json('success', 200);
    }
}
