<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Carpets;
use App\Customers;

class CarpetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carpetsList= DB::table('carpets')->join('customers', 'carpets.customer_id', '=', 'customers.id')->select('carpets.*', 'customers.name')->get();
        return view('admin.carpetView.index',compact('carpetsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.carpetView.create');
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
            'color_of_carpet' => 'required',
            'length_of_carpets' => 'required',
            'width_of_carpets' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ],
        [
            'color_of_carpet.required' => 'Warna karpet tidak boleh kosong!',
            'length_of_carpets.required' => 'Panjang karpet tidak boleh kosong!',
            'width_of_carpets.required' => 'Lebar karpet tidak boleh kosong!',
            'amount_of_wash.numeric' => 'Jumlah cuci harus angka!',
            'customer_name.required' => 'Nama Customer tidak boleh kosong!',
        ]);
        $carpetDataform=$request->except('_token','updated_at','created_at');
        $carpetData = Customers::select('id')
            ->where('name', '=', $carpetDataform['customer_name'])
            ->get()->toArray();
        
        //passing worker_id ke array baru   
        $customerData = ["customer_id"=>$carpetData[0]['id']];
        ////gabung array baru dengan array form
        $carpetData = array_merge($carpetDataform,$customerData);
        $saved = Carpets::create($carpetData);
        return redirect()->route('carpet.index');
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
        $carpetsFind = DB::table('carpets')->join('customers', 'carpets.customer_id', '=', 'customers.id')
            ->select('carpets.*', 'customers.name as customer')->where('carpets.id','=',$id)->get();
        // dd($carpetsFind);
        //casting multidimentional array ke single dimentional array
        $carpetsFind = (array) $carpetsFind[0];
        unset($carpetsFind['customer_id']);
        return view('admin.carpetView.edit',compact('carpetsFind'));
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
            'color_of_carpet' => 'required',
            'length_of_carpets' => 'required',
            'width_of_carpets' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ],
        [
            'color_of_carpet.required' => 'Warna karpet tidak boleh kosong!',
            'length_of_carpets.required' => 'Panjang karpet tidak boleh kosong!',
            'width_of_carpets.required' => 'Lebar karpet tidak boleh kosong!',
            'amount_of_wash.numeric' => 'Jumlah cuci harus angka!',
            'customer_name.required' => 'Nama Customer tidak boleh kosong!',
        ]);
        $carpetDataform=$request->except('_token','updated_at','created_at');
        // dd($carpetDataform);
        $carpetData = Customers::select('id')
            ->where('name', '=', $carpetDataform['customer_name'])
            ->get()->toArray();
        //passing worker_id ke array baru   
        $customerData = ["customer_id"=>$carpetData[0]['id']];
        ////gabung array baru dengan array form
        $carpetData = array_merge($carpetDataform,$customerData);
        //menghapus data yang tidak diperlukan
        unset($carpetData['customer_name']);
        $carpetsUpdate = Carpets::whereId($id)->update($carpetData);
        return redirect()->route('carpet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Carpets::find($id)->delete();
        return redirect()->route('carpet.index');
    }

    public function findByColor(Request $request){
        $carpetPlateData = $request->except('_token','updated_at','created_at');
        $carpetsData = carpets::where('color_of_carpet', '=', $carpetPlateData)->get();
        return view('admin.carpetView.index',compact('carpetsData'));
    }
}
