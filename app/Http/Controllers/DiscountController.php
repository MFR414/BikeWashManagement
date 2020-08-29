<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discounts;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discountsList= Discounts::all();
        return view('admin.discountView.index',compact('discountsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discountView.create');
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
            'discount_code' => 'required',
            'discount_desc' => 'required',
            'discount_type' => 'required',
            'status' => 'required|max:50',
            'discount_value' => 'required|numeric',
            'min_wash_value' => 'required|numeric',
            // 'start_at' => 'required|date',
            // 'end_at' => 'required|date',
        ],
        [
            'discount_code.required' => 'Kode diskon tidak boleh kosong!',
            'discount_desc.required' => 'Keterangan diskon tidak boleh kosong!',
            'discount_type' => 'Pilih Tipe Diskon',
            'status.required' => 'Status tidak boleh kosong!',
            'discount_value.required' => 'Presentase diskon tidak boleh kosong!',
            'discount_value.numeric' => 'Presentase diskon harus diisi angka!',
            'min_wash_value.required' => 'Minimal cuci tidak boleh kosong!',
            'min_wash_value.numeric' => 'Minimal cuci harus diisi angka!',
            // 'start_at.required' => 'Tanggal diskon mulai tidak boleh kosong!',
            // 'end_at.required' => 'Tanggal diskon selesai tidak boleh kosong!',

        ]);
        $discountDataform=$request->except('_token','updated_at','created_at');
        // dd($discountsDataform);
        $saved = Discounts::create($discountDataform);
        return redirect()->route('discount.index');
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
        $discountsFind = Discounts::findOrFail($id);
        $discType[0]=["disc_type"=>"khusus","name"=>"Khusus"];
        $discType[1]=["disc_type"=>"tetap","name"=>"Tetap"];
        $status[0]=["status"=>"active","name"=>"Aktif"];
        $status[1]=["status"=>"expired","name"=>"Tidak Aktif"];
        // dd($status);
        return view('admin.discountView.edit',compact('discountsFind','discType','status'));
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
            'discount_code' => 'required',
            'discount_desc' => 'required',
            'discount_type' => 'required',
            'status' => 'required|max:50',
            'discount_value' => 'required|numeric',
            'min_wash_value' => 'required|numeric',
            // 'start_at' => 'required|date',
            // 'end_at' => 'required|date',
        ],
        [
            'discount_code.required' => 'Kode diskon tidak boleh kosong!',
            'discount_desc.required' => 'Keterangan diskon tidak boleh kosong!',
            'discount_type' => 'Pilih Tipe Diskon',
            'status.required' => 'Status tidak boleh kosong!',
            'discount_value.required' => 'Presentase diskon tidak boleh kosong!',
            'discount_value.numeric' => 'Presentase diskon harus diisi angka!',
            'min_wash_value.required' => 'Minimal cuci tidak boleh kosong!',
            'min_wash_value.numeric' => 'Minimal cuci harus diisi angka!',
            // 'start_at.required' => 'Tanggal diskon mulai tidak boleh kosong!',
            // 'end_at.required' => 'Tanggal diskon selesai tidak boleh kosong!',

        ]);
        $discountsDataform=$request->except('_token','updated_at','created_at');
        // dd($discountsDataform);
        $DiscountsUpdate = Discounts::whereId($id)->update($discountsDataform);
        return redirect()->route('discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discounts::find($id)->delete();
        return redirect()->route('discount.index');
    }
}
