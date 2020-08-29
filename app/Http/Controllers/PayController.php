<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\BikeHistories;
use App\CarpetHistories;
use App\Customers;
use App\BikeQueues;
use App\CarpetQueues;
use App\Bikes;
use App\Carpets;
use Carbon\Carbon;

class PayController extends Controller
{
    public function displaySearch(){
        return view('admin.payView.searchQueue');
    }
    public function searchQueue(Request $request){
        $validateData = $request->validate([
            'id_antri' => 'required',
            'jenis_antri' => 'required',
        ],
        [
            'id_antri.required' => 'Id Antrian tidak boleh kosong!',
            'jenis_antri.required' => 'Jenis Antrian tidak boleh kosong!',
        ]);
        $request = $request->except('_token','updated_at','created_at');
        // dd($request);
        if($request['jenis_antri']=='bike'){
            $bikequeuesFind= DB::table('bike_queues')
            ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
            ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
            ->join('workers', 'bike_queues.worker_id', '=', 'workers.id')
            ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
            ->select('bike_queues.id','bikes.license_plate','bikes.type_of_bike','workers.name as worker_name','wash_type.wash_type','wash_type.price','customers.name as customers','customers.deposited_money as deposit')
            ->where('bike_queues.id','=',$request['id_antri'])->get()->toArray();
            // dd($bikequeuesFind);
            if(count($bikequeuesFind)==0){
                return redirect()->route('paying.searchform')->with('status','Antrian tidak ditemukan/Data antrian tidak lengkap');
            }else{
                return view('admin.payView.bikePayProcess',compact('bikequeuesFind'));
            }
        }else{
            $carpetqueuesFind= DB::table('carpet_queues')
            ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
            ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
            ->join('workers as worker1', 'carpet_queues.worker1_id', '=', 'worker1.id')
            ->join('workers as worker2', 'carpet_queues.worker2_id', '=', 'worker2.id')
            ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
            ->select('carpet_queues.id','carpets.color_of_carpet','carpets.type_of_carpet','carpets.length_of_carpets','carpets.width_of_carpets','worker1.name as worker1','worker2.name as worker2','wash_type.price_per_meter as price','wash_type.wash_type','customers.name as customer','customers.deposited_money as deposit')
            ->where('carpet_queues.id','=',$request['id_antri'])->get()->toArray();
            $carpetqueuesFind[0]->price = ($carpetqueuesFind[0]->length_of_carpets * $carpetqueuesFind[0]->width_of_carpets / 10000) * $carpetqueuesFind[0]->price;
            $carpetqueuesFind[0]->carpet_wide= $carpetqueuesFind[0]->length_of_carpets * $carpetqueuesFind[0]->width_of_carpets / 10000;
            // dd($carpetqueuesFind);
            if(count($carpetqueuesFind)==0){
                return redirect()->route('paying.searchform')->with('status','Antrian tidak ditemukan/Data antrian tidak lengkap');
            }else{
                return view('admin.payView.carpetPayProcess',compact('carpetqueuesFind'));
            }
        }
    }

    public function bikePayingProcess(Request $request,$id){
        if($request['type_of_payment']=='cash'){
            $validateData = $request->validate([
                'paid_amount' => 'required',
            ],
            [
                'paid_amount.required' => 'Uang yang dibayarkan tidak boleh kosong!',
            ]);

            $request = $request->except('_token','updated_at','created_at');
            
            $bikequeuesFind= DB::table('bike_queues')
            ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
            ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
            ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
            ->select('bike_queues.bike_id','bike_queues.customer_id as cust_id','bike_queues.worker_id','bike_queues.washtype_id','bikes.amount_of_wash','wash_type.price')
            ->where('bike_queues.id','=',$id)->get()->toArray();

            if(!is_null($request['discount_code'])){
                if($request['paid_amount']>=$bikequeuesFind[0]->price){
                    $discountCheck= DB::table('discounts')
                    ->select('discounts.discount_type')
                    ->where('discounts.discount_code','=',$request['discount_code'])->get();
                    
                    if($discountCheck[0]->discount_type == "tetap"){
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.status','=','active')
                        ->where('discounts.discount_type','=','tetap')
                        ->where('discounts.min_wash_value','<=',$bikequeuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda');
                        }
                    }else{
                        $now = Carbon::now()->toDateString();
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.discount_type','=','khusus')
                        ->where('discounts.status','=','active')
                        ->where('discounts.start_at','<=',$now)
                        ->where('discounts.end_at','>=',$now)
                        ->where('discounts.min_wash_value','<=',$bikequeuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                        }
                    }
                    
                    // dd($discountFind);
                    

                    if(count($discountFind)>0){
                        $discountNominal=($discountFind[0]->discount_value/100)*$bikequeuesFind[0]->price;
                        $discountedPrice = ($bikequeuesFind[0]->price)-($discountNominal);
                        $changes = $request['paid_amount'] - $discountedPrice;

                        $dataForView=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$bikequeuesFind[0]->price,
                            'paid_amount'=>$discountedPrice,
                            'money_paid'=>$request['paid_amount'],
                            'changes'=>$changes
                        ];

                        $updateAmountWash=[
                            'amount_of_wash'=>($bikequeuesFind[0]->amount_of_wash + 1)
                        ];

                        $bikeHistoriesData=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$discountedPrice,
                            'paid_amount'=>$discountedPrice,
                            'changes'=>$changes,
                            'pay_status'=>'lunas',
                            'type_of_payment'=>$request['type_of_payment'],
                            'cust_id'=>$bikequeuesFind[0]->cust_id,
                            'bike_id'=>$bikequeuesFind[0]->bike_id,
                            'admin_id'=>Auth::id(),
                            'worker_id'=>$bikequeuesFind[0]->worker_id,
                            'discount_id'=>$discountFind[0]->id,
                            'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                            'washtype_id'=>$bikequeuesFind[0]->washtype_id,
                        ];

                        BikeHistories::create($bikeHistoriesData);
                        Bikes::find($bikequeuesFind[0]->bike_id)->update($updateAmountWash);
                        BikeQueues::find($id)->delete();

                        return view('admin.payView.cashCompletePayView',compact('dataForView'));
                        
                    }else{                    
                        return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon');
                    }
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }else{
                if($request['paid_amount']>=$bikequeuesFind[0]->price){
                    $changes = $request['paid_amount'] - ($bikequeuesFind[0]->price);

                    $dataForView=[
                        'total_disc'=>0,
                        'total_pay'=>$bikequeuesFind[0]->price,
                        'paid_amount'=>$bikequeuesFind[0]->price,
                        'money_paid'=>$request['paid_amount'],
                        'changes'=>$changes
                    ];

                    $updateAmountWash=[
                        'amount_of_wash'=>($bikequeuesFind[0]->amount_of_wash + 1)
                    ];

                    $bikeHistoriesData=[
                        'total_disc'=>0,
                        'total_pay'=>$bikequeuesFind[0]->price,
                        'paid_amount'=>$bikequeuesFind[0]->price,
                        'money_paid'=>$request['paid_amount'],
                        'changes'=>$changes,
                        'pay_status'=>'lunas',
                        'type_of_payment'=>$request['type_of_payment'],
                        'cust_id'=>$bikequeuesFind[0]->cust_id,
                        'bike_id'=>$bikequeuesFind[0]->bike_id,
                        'admin_id'=>Auth::id(),
                        'worker_id'=>$bikequeuesFind[0]->worker_id,
                        'discount_id'=>null,
                        'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                        'washtype_id'=>$bikequeuesFind[0]->washtype_id,
                    ];

                    BikeHistories::create($bikeHistoriesData);
                    Bikes::find($bikequeuesFind[0]->bike_id)->update($updateAmountWash);
                    BikeQueues::find($id)->delete();

                    return view('admin.payView.cashCompletePayView',compact('dataForView'));
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }
            
        }else{
            $request = $request->except('_token','updated_at','created_at');
            
            $bikequeuesFind= DB::table('bike_queues')
            ->join('customers', 'bike_queues.customer_id', '=', 'customers.id')
            ->join('bikes', 'bike_queues.bike_id', '=', 'bikes.id')
            ->join('wash_type', 'bike_queues.washtype_id', '=', 'wash_type.id')
            ->select('bike_queues.bike_id','bike_queues.customer_id as cust_id','bike_queues.worker_id','bike_queues.washtype_id','bikes.amount_of_wash','wash_type.price','customers.deposited_money')
            ->where('bike_queues.id','=',$id)->get()->toArray();

            if(!is_null($request['discount_code'])){
                if($bikequeuesFind[0]->deposited_money>=$bikequeuesFind[0]->price){
                    $discountCheck= DB::table('discounts')
                    ->select('discounts.discount_type')
                    ->where('discounts.discount_code','=',$request['discount_code'])->get();
                    
                    if($discountCheck[0]->discount_type == "tetap"){
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.status','=','active')
                        ->where('discounts.discount_type','=','tetap')
                        ->where('discounts.min_wash_value','<=',$bikequeuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda');
                        }
                    }else{
                        $now = Carbon::now()->toDateString();
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.discount_type','=','khusus')
                        ->where('discounts.status','=','active')
                        ->where('discounts.start_at','<=',$now)
                        ->where('discounts.end_at','>=',$now)
                        ->where('discounts.min_wash_value','<=',$bikequeuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                        }
                    }

                    if(count($discountFind)>0){
                        $discountNominal=($discountFind[0]->discount_value/100)*$bikequeuesFind[0]->price;
                        $discountedPrice = ($bikequeuesFind[0]->price) - ($discountNominal);
                        $changes = $bikequeuesFind[0]->deposited_money - $discountedPrice;

                        $dataForView=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$bikequeuesFind[0]->price,
                            'paid_amount'=>$discountedPrice,
                            'money_paid'=>$bikequeuesFind[0]->deposited_money,
                            'deposited_money'=>$changes
                        ];

                        $updateDeposit=[
                            'deposited_money'=>$changes
                        ];

                        $updateAmountWash=[
                            'amount_of_wash'=>($bikequeuesFind[0]->amount_of_wash + 1)
                        ];

                        $bikeHistoriesData=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$discountedPrice,
                            'paid_amount'=>$discountedPrice,
                            'changes'=>$changes,
                            'pay_status'=>'lunas',
                            'type_of_payment'=>$request['type_of_payment'],
                            'cust_id'=>$bikequeuesFind[0]->cust_id,
                            'bike_id'=>$bikequeuesFind[0]->bike_id,
                            'admin_id'=>Auth::id(),
                            'worker_id'=>$bikequeuesFind[0]->worker_id,
                            'discount_id'=>$discountFind[0]->id,
                            'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                            'washtype_id'=>$bikequeuesFind[0]->washtype_id,
                        ];

                        BikeHistories::create($bikeHistoriesData);
                        Customers::find($bikequeuesFind[0]->cust_id)->update($updateDeposit);
                        Bikes::find($bikequeuesFind[0]->bike_id)->update($updateAmountWash);
                        BikeQueues::find($id)->delete();

                        return view('admin.payView.depositCompletePayView',compact('dataForView'));
                    }else{
                        return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                    }
                }else{
                    return redirect()->route('paying.searchform')->with('status','Saldo deposit tidak cukup');
                }
            }else{
                if($bikequeuesFind[0]->deposited_money>=$bikequeuesFind[0]->price){
                    $changes = $bikequeuesFind[0]->deposited_money - ($bikequeuesFind[0]->price);

                    $dataForView=[
                        'total_disc'=>0,
                        'total_pay'=>$bikequeuesFind[0]->price,
                        'paid_amount'=>$bikequeuesFind[0]->price,
                        'money_paid'=>$bikequeuesFind[0]->deposited_money,
                        'deposited_money'=>$changes
                    ];

                    $updateDeposit=[
                        'deposited_money'=>$changes
                    ];

                    $updateAmountWash=[
                        'amount_of_wash'=>($bikequeuesFind[0]->amount_of_wash + 1)
                    ];

                    $bikeHistoriesData=[
                        'total_disc'=>0,
                        'total_pay'=>$bikequeuesFind[0]->price,
                        'paid_amount'=>$bikequeuesFind[0]->price,
                        'money_paid'=>$bikequeuesFind[0]->deposited_money,
                        'changes'=>$changes,
                        'pay_status'=>'lunas',
                        'type_of_payment'=>$request['type_of_payment'],
                        'cust_id'=>$bikequeuesFind[0]->cust_id,
                        'bike_id'=>$bikequeuesFind[0]->bike_id,
                        'admin_id'=>Auth::id(),
                        'worker_id'=>$bikequeuesFind[0]->worker_id,
                        'discount_id'=>null,
                        'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                        'washtype_id'=>$bikequeuesFind[0]->washtype_id,
                    ];

                    BikeHistories::create($bikeHistoriesData);
                    Customers::find($bikequeuesFind[0]->cust_id)->update($updateDeposit);
                    Bikes::find($bikequeuesFind[0]->bike_id)->update($updateAmountWash);
                    BikeQueues::find($id)->delete();

                    return view('admin.payView.depositCompletePayView',compact('dataForView'));
                }else{
                    return redirect()->route('paying.searchform')->with('status','Saldo deposit tidak cukup');
                }
            }
        }
    }


    public function carpetPayingProcess(Request $request,$id){
        if($request['type_of_payment']=='cash'){
            $validateData = $request->validate([
                'paid_amount' => 'required',
            ],
            [
                'paid_amount.required' => 'Uang yang dibayarkan tidak boleh kosong!',
            ]);

            $request = $request->except('_token','updated_at','created_at');
            
            $carpetqueuesFind= DB::table('carpet_queues')
            ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
            ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
            ->join('workers as worker1', 'carpet_queues.worker1_id', '=', 'worker1.id')
            ->join('workers as worker2', 'carpet_queues.worker2_id', '=', 'worker2.id')
            ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
            ->select('carpet_queues.id','carpet_queues.customer_id as cust_id','carpet_queues.carpet_id','carpet_queues.worker1_id','carpet_queues.worker2_id','carpet_queues.washtype_id','carpets.length_of_carpets','carpets.width_of_carpets','carpets.amount_of_wash','worker1.name as worker1','worker2.name as worker2','wash_type.price_per_meter as price','wash_type.wash_type','customers.name as customer','customers.deposited_money as deposit')
            ->where('carpet_queues.id','=',$id)->get()->toArray();

            $countPriceTotal= ($carpetqueuesFind[0]->length_of_carpets * $carpetqueuesFind[0]->width_of_carpets / 10000) * $carpetqueuesFind[0]->price;
            $carpetqueuesFind[0]->price = $countPriceTotal;

            if(!is_null($request['discount_code'])){
                if($request['paid_amount']>=$carpetqueuesFind[0]->price){
                    $discountCheck= DB::table('discounts')
                    ->select('discounts.discount_type')
                    ->where('discounts.discount_code','=',$request['discount_code'])->get();
                    
                    if($discountCheck[0]->discount_type == "tetap"){
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.status','=','active')
                        ->where('discounts.discount_type','=','tetap')
                        ->where('discounts.min_wash_value','<=',$carpetqueuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda');
                        }
                    }else{
                        $now = Carbon::now()->toDateString();
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.discount_type','=','khusus')
                        ->where('discounts.status','=','active')
                        ->where('discounts.start_at','<=',$now)
                        ->where('discounts.end_at','>=',$now)
                        ->where('discounts.min_wash_value','<=',$carpetqueuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                        }
                    }

                    if(count($discountFind)>0){
                        $discountNominal=($discountFind[0]->discount_value/100)*$carpetqueuesFind[0]->price;
                        $discountedPrice = ($carpetqueuesFind[0]->price)-($discountNominal);
                        $changes = $request['paid_amount'] - $discountedPrice;

                        $dataForView=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$carpetqueuesFind[0]->price,
                            'paid_amount'=>$discountedPrice,
                            'money_paid'=>$request['paid_amount'],
                            'changes'=>$changes
                        ];

                        $updateAmountWash=[
                            'amount_of_wash'=>($carpetqueuesFind[0]->amount_of_wash + 1)
                        ];

                        $carpetHistoriesData=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$discountedPrice,
                            'paid_amount'=>$discountedPrice,
                            'changes'=>$changes,
                            'pay_status'=>'lunas',
                            'type_of_payment'=>$request['type_of_payment'],
                            'cust_id'=>$carpetqueuesFind[0]->cust_id,
                            'carpet_id'=>$carpetqueuesFind[0]->carpet_id,
                            'admin_id'=>Auth::id(),
                            'worker1_id'=>$carpetqueuesFind[0]->worker1_id,
                            'worker2_id'=>$carpetqueuesFind[0]->worker2_id,
                            'discount_id'=>$discountFind[0]->id,
                            'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                            'washtype_id'=>$carpetqueuesFind[0]->washtype_id,
                        ];

                        CarpetHistories::create($carpetHistoriesData);
                        Carpets::find($carpetqueuesFind[0]->carpet_id)->update($updateAmountWash);
                        CarpetQueues::find($id)->delete();

                        return view('admin.payView.cashCompletePayView',compact('dataForView'));
                    }else{
                        return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                    }
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }else{
                if($request['paid_amount']>=$carpetqueuesFind[0]->price){
                    $changes = $request['paid_amount'] - ($carpetqueuesFind[0]->price);

                    $dataForView=[
                        'total_disc'=>0,
                        'total_pay'=>$carpetqueuesFind[0]->price,
                        'paid_amount'=>$carpetqueuesFind[0]->price,
                        'money_paid'=>$request['paid_amount'],
                        'changes'=>$changes
                    ];

                    $updateAmountWash=[
                        'amount_of_wash'=>($carpetqueuesFind[0]->amount_of_wash + 1)
                    ];

                    $carpetHistoriesData=[
                        'total_disc'=>0,
                        'total_pay'=>$carpetqueuesFind[0]->price,
                        'paid_amount'=>$carpetqueuesFind[0]->price,
                        'money_paid'=>$request['paid_amount'],
                        'changes'=>$changes,
                        'pay_status'=>'lunas',
                        'type_of_payment'=>$request['type_of_payment'],
                        'cust_id'=>$carpetqueuesFind[0]->cust_id,
                        'carpet_id'=>$carpetqueuesFind[0]->carpet_id,
                        'admin_id'=>Auth::id(),
                        'worker1_id'=>$carpetqueuesFind[0]->worker1_id,
                        'worker2_id'=>$carpetqueuesFind[0]->worker2_id,
                        'discount_id'=>null,
                        'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                        'washtype_id'=>$carpetqueuesFind[0]->washtype_id,
                    ];

                    CarpetHistories::create($carpetHistoriesData);
                    Carpets::find($carpetqueuesFind[0]->carpet_id)->update($updateAmountWash);
                    CarpetQueues::find($id)->delete();

                    return view('admin.payView.cashCompletePayView',compact('dataForView'));
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }
            
        }else{
            $request = $request->except('_token','updated_at','created_at');
            
            $carpetqueuesFind= DB::table('carpet_queues')
            ->join('customers', 'carpet_queues.customer_id', '=', 'customers.id')
            ->join('carpets', 'carpet_queues.carpet_id', '=', 'carpets.id')
            ->join('workers as worker1', 'carpet_queues.worker1_id', '=', 'worker1.id')
            ->join('workers as worker2', 'carpet_queues.worker2_id', '=', 'worker2.id')
            ->join('wash_type', 'carpet_queues.washtype_id', '=', 'wash_type.id')
            ->select('carpet_queues.id','carpet_queues.customer_id as cust_id','carpet_queues.carpet_id','carpet_queues.worker1_id','carpet_queues.worker2_id','carpet_queues.washtype_id','carpets.length_of_carpets','carpets.width_of_carpets','carpets.amount_of_wash','worker1.name as worker1','worker2.name as worker2','wash_type.price_per_meter as price','wash_type.wash_type','customers.name as customer','customers.deposited_money as deposit')
            ->where('carpet_queues.id','=',$id)->get()->toArray();

            $countPriceTotal= ($carpetqueuesFind[0]->length_of_carpets * $carpetqueuesFind[0]->width_of_carpets / 10000) * $carpetqueuesFind[0]->price;
            $carpetqueuesFind[0]->price = $countPriceTotal;

            if(!is_null($request['discount_code'])){
                if($carpetqueuesFind[0]->deposit>=$carpetqueuesFind[0]->price){
                    $discountCheck= DB::table('discounts')
                    ->select('discounts.discount_type')
                    ->where('discounts.discount_code','=',$request['discount_code'])->get();
                    
                    if($discountCheck[0]->discount_type == "tetap"){
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.status','=','active')
                        ->where('discounts.discount_type','=','tetap')
                        ->where('discounts.min_wash_value','<=',$carpetqueuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda');
                        }
                    }else{
                        $now = Carbon::now()->toDateString();
                        $discountFind= DB::table('discounts')
                        ->select('discounts.id','discounts.discount_value')
                        ->where('discounts.discount_code','=',$request['discount_code'])
                        ->where('discounts.discount_type','=','khusus')
                        ->where('discounts.status','=','active')
                        ->where('discounts.start_at','<=',$now)
                        ->where('discounts.end_at','>=',$now)
                        ->where('discounts.min_wash_value','<=',$carpetqueuesFind[0]->amount_of_wash)
                        ->get()->toArray();
                        if(is_null($discountFind)){
                            return redirect()->route('paying.searchform')->with('status','Tidak memenuhi syarat diskon.Cek kembali jumlah cuci anda,status diskon,tanggal berlaku diskon tersebut.');
                        }
                    }

                    if(count($discountFind)>0){
                        $discountNominal=($discountFind[0]->discount_value/100)*$carpetqueuesFind[0]->price;
                        $discountedPrice = ($carpetqueuesFind[0]->price) - ($discountNominal);
                        $changes = $carpetqueuesFind[0]->deposit - $discountedPrice;

                        $dataForView=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$carpetqueuesFind[0]->price,
                            'paid_amount'=>$discountedPrice,
                            'money_paid'=>$carpetqueuesFind[0]->deposit,
                            'deposited_money'=>$changes
                        ];

                        $updateDeposit=[
                            'deposited_money'=>$changes
                        ];

                        $updateAmountWash=[
                            'amount_of_wash'=>($carpetqueuesFind[0]->amount_of_wash + 1)
                        ];

                        $carpetHistoriesData=[
                            'total_disc'=>$discountNominal,
                            'total_pay'=>$discountedPrice,
                            'paid_amount'=>$discountedPrice,
                            'changes'=>$changes,
                            'pay_status'=>'lunas',
                            'type_of_payment'=>$request['type_of_payment'],
                            'cust_id'=>$carpetqueuesFind[0]->cust_id,
                            'carpet_id'=>$carpetqueuesFind[0]->carpet_id,
                            'admin_id'=>Auth::id(),
                            'worker1_id'=>$carpetqueuesFind[0]->worker1_id,
                            'worker2_id'=>$carpetqueuesFind[0]->worker2_id,
                            'discount_id'=>$discountFind[0]->id,
                            'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                            'washtype_id'=>$carpetqueuesFind[0]->washtype_id,
                        ];

                        CarpetHistories::create($carpetHistoriesData);
                        Customers::find($carpetqueuesFind[0]->cust_id)->update($updateDeposit);
                        Carpets::find($carpetqueuesFind[0]->carpet_id)->update($updateAmountWash);
                        CarpetQueues::find($id)->delete();

                        return view('admin.payView.depositCompletePayView',compact('dataForView'));
                    }else{
                        return redirect()->route('paying.searchform')->with('status','Kode diskon tidak sesuai');
                    }
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }else{
                if($carpetqueuesFind[0]->deposit>=$carpetqueuesFind[0]->price){
                    $changes = $carpetqueuesFind[0]->deposit - ($carpetqueuesFind[0]->price);

                    $dataForView=[
                        'total_disc'=>0,
                        'total_pay'=>$carpetqueuesFind[0]->price,
                        'paid_amount'=>$carpetqueuesFind[0]->price,
                        'money_paid'=>$carpetqueuesFind[0]->deposit,
                        'deposited_money'=>$changes
                    ];

                    $updateDeposit=[
                        'deposited_money'=>$changes
                    ];

                    $updateAmountWash=[
                        'amount_of_wash'=>($carpetqueuesFind[0]->amount_of_wash + 1)
                    ];

                    $carpetHistoriesData=[
                        'total_disc'=>0,
                        'total_pay'=>$carpetqueuesFind[0]->price,
                        'paid_amount'=>$carpetqueuesFind[0]->price,
                        'money_paid'=>$carpetqueuesFind[0]->deposit,
                        'changes'=>$changes,
                        'pay_status'=>'lunas',
                        'type_of_payment'=>$request['type_of_payment'],
                        'cust_id'=>$carpetqueuesFind[0]->cust_id,
                        'carpet_id'=>$carpetqueuesFind[0]->carpet_id,
                        'admin_id'=>Auth::id(),
                        'worker1_id'=>$carpetqueuesFind[0]->worker1_id,
                        'worker2_id'=>$carpetqueuesFind[0]->worker2_id,
                        'discount_id'=>null,
                        'saved_at'=>Carbon::now('Asia/Jakarta')->toDateString(),
                        'washtype_id'=>$carpetqueuesFind[0]->washtype_id,
                    ];

                    CarpetHistories::create($carpetHistoriesData);
                    Customers::find($carpetqueuesFind[0]->cust_id)->update($updateDeposit);
                    Carpets::find($carpetqueuesFind[0]->carpet_id)->update($updateAmountWash);
                    CarpetQueues::find($id)->delete();

                    return view('admin.payView.depositCompletePayView',compact('dataForView'));
                }else{
                    return redirect()->route('paying.searchform')->with('status','Uang yang dibayarkan tidak cukup');
                }
            }
        }
    }
}
