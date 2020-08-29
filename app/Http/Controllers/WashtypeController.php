<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Washtypes;

class WashtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $washtypeList= Washtypes::all();
        return view('admin.washtypeView.index',compact('washtypeList'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.washtypeView.create');
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
            'wash_type' => 'required',
            'type_of_goods' => 'required'
        ],
        [
            'wash_type.required' => 'Tipe cuci tidak boleh kosong!',
            'type_of_goods.required' => 'Tipe barang tidak boleh kosong!',
        ]);
        $washtypeDataform=$request->except('_token','updated_at','created_at');
        // dd($washtypeDataform);
        $saved = Washtypes::create($washtypeDataform);
        return redirect()->route('washtype.index');
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
        $washtypeFind = Washtypes::findOrFail($id);
        return view('admin.washtypeView.edit',compact('washtypeFind'));
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
            'wash_type' => 'required',
            'type_of_goods' => 'required',
        ],
        [
            'wash_type.required' => 'Tipe cuci tidak boleh kosong!',
            'type_of_goods.required' => 'Tipe barang tidak boleh kosong!',
        ]);
        $washtypeDataform=$request->except('_token','updated_at','created_at');
        // dd($WashtypeDataform);
        $washtypeUpdate = Washtypes::whereId($id)->update($washtypeDataform);
        return redirect()->route('washtype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Washtypes::find($id)->delete();
        return redirect()->route('washtype.index');
    }

    //search data from name
    public function findByWashtype(Request $request){
        $washtypeData = $request->except('_token','updated_at','created_at');
        $washtypeList = Washtypes::where('wash_type', '=', $washtypeData)->get();
        // dd($customerId);
        return view('admin.washtypeView.index',compact('washtypeList'));
    }
}
