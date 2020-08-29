<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Washtypes;
use App\Http\Controllers\Controller;

class APIWashtypeController extends Controller
{
    public function index(){
        $washtype = Washtypes::all();
        return response()->json($washtype, 200);
    }

    public function show($id){
        $washtype = Washtypes::find($id);
        if (is_null($washtype)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($washtype, 200);
        }
    }
}
