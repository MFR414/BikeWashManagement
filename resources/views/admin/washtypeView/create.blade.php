@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Jenis Cuci</h3>
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
                
               <form class="form-horizontal" action="{{ route('washtype.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Cuci :</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="wash_type" placeholder="Masukkan Tipe Cuci (silikon,standar)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Barang :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type_of_goods" placeholder="Masukkan Tipe Barang (karpet,motor)">
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
                        <label class="control-label col-sm-2">Jenis Karpet :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type_of_carpets" placeholder="Masukkan Jenis Karpet (tipis,sedang,tebal)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Harga Per Meter :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price_per_meter" placeholder="Masukkan Harga per Meter (angka tanpa titik)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Harga :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price" placeholder="Masukkan Harga (angka tanpa titik)">
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