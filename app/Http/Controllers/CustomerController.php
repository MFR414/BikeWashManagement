<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerList= Customers::all();
        return view('admin.customerView.index',compact('customerList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customerView.create');
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
            'address.required' => 'Alamat tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
        ]);
        $customerDataform=$request->except('_token','updated_at','created_at');
        $saved = Customers::create($customerDataform);
        return redirect()->route('customer.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customerFind = Customers::findOrFail($id);
        return view('admin.customerView.edit',compact('customerFind'));
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
            'address.required' => 'Alamat tidak boleh kosong!',
            'phone_number.required' => 'Nomor telefon tidak boleh kosong!',
        ]);
        $customerDataform=$request->except('_token','updated_at','created_at');
        $customerUpdate = Customers::whereId($id)->update($customerDataform);
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customers::find($id)->delete();
        return redirect()->route('customer.index');
    }

    public function findByNameToIndex(Request $request){
        $customerNameData = $request->except('_token','updated_at','created_at');
        $customerList = Customers::whereName($customerNameData)->get();
        // dd($customerList);
        return view('admin.customerView.index',compact('customerList'));
    }

    public function addMoneyShow($id){
        $customerFind = Customers::findOrFail($id);
        return view('admin.customerView.addMoney',compact('customerFind'));
    }

    public function addMoneyUpdate(Request $request, $id){
        $customerData = Customers::whereId($id)->get()->toArray();
        $customerLastMoney = $customerData[0]['deposited_money'];
        $addingMoney=$request->input('addingMoney');
        $updateMoney = ($customerLastMoney+$addingMoney);
        $customerUpdate = Customers::whereId($id)->update(['deposited_money'=>$updateMoney]);
        return redirect()->route('customer.index'); 
    }
}
