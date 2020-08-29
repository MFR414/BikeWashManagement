<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bikes;
use App\Customers;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikesList= DB::table('bikes')->join('customers', 'bikes.customer_id', '=', 'customers.id')->select('bikes.*', 'customers.name')->get();
        return view('admin.bikeView.index',compact('bikesList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bikeView.create');
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
            'type_of_bike' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'type_of_bike.required' => 'Tipe motor tidak boleh kosong!',
            'amount_of_wash.numeric' => 'Jumlah cuci harus angka!',
            'customer_name.required' => 'Nama Customer tidak boleh kosong!',
        ]);
        $bikeDataform=$request->except('_token','updated_at','created_at');
        //ambil data motor dari database
        $bikeData = Customers::select('id')
            ->where('name', '=', $bikeDataform['customer_name'])
            ->get()->toArray();
        
        //passing worker_id ke array baru   
        $customerData = ["customer_id"=>$bikeData[0]['id']];
        ////gabung array baru dengan array form
        $bikeData = array_merge($bikeDataform,$customerData);

        //menghapus data yang tidak diperlukan
        unset($bikeData['customer_name']);
        
        //simpan ke database
        $saved = Bikes::create($bikeData);
        return redirect()->route('bike.index');
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
        $bikesFind = DB::table('bikes')->join('customers', 'bikes.customer_id', '=', 'customers.id')
            ->select('bikes.*', 'customers.name as customer')->where('bikes.id','=',$id)->get();
        // dd($bikesFind);
        //casting multidimentional array ke single dimentional array
        $bikesFind = (array) $bikesFind[0];
        unset($bikesFind['customer_id']);
        return view('admin.bikeView.edit',compact('bikesFind'));
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
            'type_of_bike' => 'required',
            'amount_of_wash' => 'numeric',
            'customer_name' => 'required',
        ],
        [
            'license_plate.required' => 'Plat nomor tidak boleh kosong!',
            'type_of_bike.required' => 'Tipe motor tidak boleh kosong!',
            'amount_of_wash.numeric' => 'Jumlah cuci harus angka!',
            'customer_name.required' => 'Nama Customer tidak boleh kosong!',
        ]);
        $bikeDataform=$request->except('_token','updated_at','created_at');
        $bikeData = Customers::select('id')
            ->where('name', '=', $bikeDataform['customer_name'])
            ->get()->toArray();
        
        //passing worker_id ke array baru   
        $customerData = ["customer_id"=>$bikeData[0]['id']];
        ////gabung array baru dengan array form
        $bikeData = array_merge($bikeDataform,$customerData);
        
        //menghapus data yang tidak diperlukan
        unset($bikeData['customer_name']);
        
        $bikesUpdate = Bikes::whereId($id)->update($bikeData);
        return redirect()->route('bike.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bikes::find($id)->delete();
        return redirect()->route('bike.index');
    }

    public function findByPlate(Request $request){
        $bikePlateData = $request->except('_token','updated_at','created_at');
        $bikesList = Bikes::where('license_plate', '=', $bikePlateData)->get();
        return view('admin.bikeView.index',compact('bikesList'));
    }
}
