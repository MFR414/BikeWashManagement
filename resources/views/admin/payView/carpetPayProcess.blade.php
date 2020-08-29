@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Data Bayar</h3>
               </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
                @endif
                @foreach($carpetqueuesFind as $carpets)
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                        <h5>Warna Karpet :</h5>
                        <h4>{{$carpets->color_of_carpet}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Tipe Karpet :</h5>
                        <h4>{{$carpets->type_of_carpet}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Luas Karpet :</h5>
                        <h4>{{$carpets->carpet_wide}} Meter</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Nama Pekerja 1 :</h5>
                        <h4>{{$carpets->worker1}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Nama Pekerja 2:</h5>
                        <h4>{{$carpets->worker2}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Jenis Cuci :</h5>
                        <h4>{{$carpets->wash_type}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Total Harga :</h5>
                        <h4>{{$carpets->price}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Nama Customer :</h5>
                        <h4>{{$carpets->customer}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Jumlah Deposit Customer :<h5>
                        <h4>{{$carpets->deposit}}</h4>
                    </div>
                </div>
                @endforeach
           </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Form Bayar</h3>
                </div>
                 @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <br>
            
            @foreach($carpetqueuesFind as $carpets)
            <form class="form-horizontal" action="{{route ('paying.carpetpay',['id'=>$carpets->id])}}" method="POST">
                @csrf
            @endforeach
                    <div class="form-group">
                    <label class="control-label col-sm-4">Kode Diskon :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="discount_code" value="{{ old('discount_code') }}" placeholder="Masukkan Kode Diskon (huruf kecil)">
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Jenis Pembayaran :</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="type_of_payment">
                                <option value="cash">Tunai</option>
                                <option value="deposit">Deposit</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    <label class="control-label col-sm-4">Uang Yang Dibayarkan :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="paid_amount" value="{{ old('paid_amount') }}" placeholder="Masukkan Jumlah Uang Yang Dibayarkan (angka tanpa titik)">
                    </div>
                    </div>
    
                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <button type="submit" class="btn btn-default">Simpan</button>
                    </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</section>
@endsection