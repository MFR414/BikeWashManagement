@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Data Transaksi</h3>
               </div>
               
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                        <h5>Total Diskon :</h5>
                        <h4>{{$dataForView['total_disc']}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Jumlah Yang Harus Dibayarkan :</h5>
                        <h4>{{$dataForView['total_pay']}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Jumlah Yang Harus Dibayarkan Setelah Diskon :</h5>
                        <h4>{{$dataForView['paid_amount']}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Uang Yang Dibayarkan :</h5>
                        <h4>{{$dataForView['money_paid']}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Sisa Deposit :</h5>
                        <h4>{{$dataForView['deposited_money']}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <button type="button" onclick="window.location='{{ url('admin/pay/') }}'">kembali</button>
                    </div>
                </div>
           </div>
        </div>
    </div>
</section>
@endsection