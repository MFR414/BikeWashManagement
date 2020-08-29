<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workers;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workerList= Workers::all();
        return view('admin.workerView.index',compact('workerList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.workerView.create');
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
            'username' => 'required|max:30',
            'password' => 'required|min:5',
            'name' => 'required|max:50',
            'address' => 'required|max:100',
            'phone_number' => 'required|numeric',
        ],
        [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
            'name.required' => 'Nama tidak boleh kosong!',
            'address.required' => 'Nomor telefon tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
        ]);
        $workerDataform=$request->except('_token','updated_at','created_at');
        $saved = Workers::create($workerDataform);
        return redirect()->route('worker.index')->with('status','Pegawai Telah Ditambahkan');
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
        $workerFind = Workers::findOrFail($id);
        return view('admin.workerView.edit',compact('workerFind'));
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
            'username' => 'required|max:30',
            'password' => 'required|min:5',
            'name' => 'required|max:50',
            'address' => 'required|max:100',
            'phone_number' => 'required|numeric',
        ],
        [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
            'name.required' => 'Nama tidak boleh kosong!',
            'address.required' => 'Nomor telefon tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
        ]);
        $workerDataform=$request->except('_token','updated_at','created_at');
        $workersUpdate = Workers::whereId($id)->update($workerDataform);
        return redirect()->route('worker.index')->with('status','Pegawai Telah Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Workers::find($id)->delete();
        return redirect()->route('worker.index')->with('status','Pegawai Telah Terhapus');
    }
}
