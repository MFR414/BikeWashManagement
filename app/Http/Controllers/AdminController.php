<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminList= User::all();
        return view('admin.adminView.index',compact('adminList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.adminView.create');
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
            'password' => 'required|min:8',
            'name' => 'required|max:50',
            'phone_number' => 'required|numeric',
            'email' => 'required',
            'posisi' => 'required'
        ],
        [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
            'name.required' => 'Nama tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'posisi.required' => 'Posisi tidak boleh kosong!',
        ]);
        $adminDataform=$request->except('_token','updated_at','created_at');
        $adminDataform['password']=Hash::make($adminDataform['password']);
        $saved = User::create($adminDataform);
        return redirect()->route('owner.admin.index');
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
        $adminFind = User::findOrFail($id);
        return view('owner.adminView.edit',compact('adminFind'));
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
            'name' => 'required|max:50',
            'phone_number' => 'required|numeric',
            'email' => 'required',
            'posisi' => 'required'
        ],
        [
            'username.required' => 'Username tidak boleh kosong!',
            'name.required' => 'Nama tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'posisi.required' => 'Posisi tidak boleh kosong!',
        ]);
        $adminDataform=$request->except('_token','updated_at','created_at');
        $adminDataform['password']=Hash::make($adminDataform['password']);
        $adminsUpdate = User::whereId($id)->update($adminDataform);
        return redirect()->route('owner.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('owner.admin.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOwner()
    {
        $adminList= User::all();
        return view('owner.adminView.index',compact('adminList'));
    }
}
