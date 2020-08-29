@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Diskon</h3>
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
               <form class="form-horizontal" action="{{ route('discount.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Kode Diskon :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="discount_code" placeholder="Masukkan Kode Diskon (huruf kecil)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Keterangan Diskon :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="discount_desc" placeholder="Masukkan Keterangan Diskon (huruf kecil)">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Diskon :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="discount_type">
                                <option value="khusus" selected>khusus</option>
                                <option value="tetap">tetap</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Status :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                <option value="active" selected>aktif</option>
                                <option value="expired">tidak aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Presentase Diskon :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="discount_value" placeholder="Masukkan Keterangan Diskon (angka)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Minimal Cuci :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="min_wash_value" placeholder="Masukkan Minimal Cuci (angka)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tanggal Diskon Mulai :</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="start_at" placeholder="Masukkan Tanggal Mulai">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2">Tanggal Berakhir :</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="end_at" placeholder="Masukkan Tanggal Selesai">
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