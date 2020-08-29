<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Discounts;
use App\Http\Controllers\Controller;

class APIDiscountController extends Controller
{
    public function index(){
        $discount = Discounts::where('status','=','active')->get();
        return response()->json($discount, 200);
    }

    public function show($id){
        $discount = Discounts::find($id);
        if (is_null($discount)) {
            return response()->json([
                'message' => 'Resource not found!'
            ],404);
        }else{
            return response()->json($discount, 200);
        }
    }
}
