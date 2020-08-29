@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Motor</h3>
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
                
               <form class="form-horizontal" action="{{ route('bike.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Plat Nomor :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="license_plate" placeholder="Masukkan Plat Nomor (huruf kapital)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Motor :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type_of_bike" placeholder="Masukkan Tipe Motor (matic,sport,bebek)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Ukuran Motor :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="size_of_bike" placeholder="Masukkan Ukuran Motor (sedang,besar)">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Jumlah Cuci :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="amount_of_wash" value="0" placeholder="Masukkan Jumlah Cuci (angka)" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Catatan :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="note" placeholder="Masukkan Catatan (huruf kecil)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama Pelanggan :</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="customer_name" placeholder="Masukkan Nama Pelanggan (huruf kecil)">
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Tambah</button>
                    </div>
                    </div>
                </form> 
           </div>
        </div>
    </div>
</section>
@endsection