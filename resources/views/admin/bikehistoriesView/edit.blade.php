@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Edit Histori Cuci Motor</h3>
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
               <form class="form-horizontal" action="{{ route('bike.update',['id'=> $bikesFind->id]) }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Plat Nomor :</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="license_plate" value="{{$bikesFind->license_plate}}" placeholder="Enter License Plate">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Motor :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type_of_bike" value="{{$bikesFind->type_of_bike}}" placeholder="Enter Type Of Bike">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Ukuran Motor :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="size_of_bike" value="{{$bikesFind->size_of_bike}}" placeholder="Enter Size Of Bike">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Jumlah Cuci :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="amount_of_wash" value="{{$bikesFind->amount_of_wash}}" placeholder="Enter Amount Of Wash">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Catatan :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="note" value="{{$bikesFind->note}}" placeholder="Enter A Note">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Id Pelanggan :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="customer_id" value="{{$bikesFind->customer_id}}" placeholder="Enter Customer Id">
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Simpan</button>
                    </div>
                    </div>
                </form> 
           </div>
        </div>
    </div>
</section>
@endsection