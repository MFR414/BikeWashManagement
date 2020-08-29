@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Karpet</h3>
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
                
               <form class="form-horizontal" action="{{ route('carpet.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Warna Karpet :</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="color_of_carpet" placeholder="Masukkan Warna Karpet (huruf kecil)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Panjang Karpet :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="length_of_carpets" placeholder="Masukkan Panjang Karpet (angka dalam cm)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Lebar Karpet :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="width_of_carpets" placeholder="Masukkan Lebar Karpet (angka dalam cm)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Karpet :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type_of_carpet" placeholder="Masukkan Tipe Karpet (tipis,sedang,tebal)">
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