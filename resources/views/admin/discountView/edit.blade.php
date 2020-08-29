@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Edit Diskon</h3>
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
               <form class="form-horizontal" action="{{ route('discount.update',['id'=> $discountsFind->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2">Kode Diskon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="discount_code" placeholder="Masukkan Kode Diskon (huruf kecil)" value="{{ $discountsFind->discount_code }}">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Keterangan Diskon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="discount_desc" placeholder="Masukkan Keterangan Diskon (huruf kecil)" value="{{ $discountsFind->discount_desc }}">
                    </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipe Diskon :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="discount_type">
                                @for($i=0;$i<count($discType);$i++)
                                  <option value="{{$discType[$i]['disc_type']}}" {{ ( $discType[$i]['disc_type'] == $discountsFind->discount_type) ? 'selected' : '' }}>{{$discType[$i]['name'] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Status :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                @for($a=0;$a<count($status);$a++)
                                  <option value="{{$status[$a]['status']}}" {{ ( $status[$a]['status'] == $discountsFind->status) ? 'selected' : '' }}>{{$status[$a]['name'] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Presentase Diskon :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="discount_value" placeholder="Masukkan Presentase Diskon (angka)" value="{{ $discountsFind->discount_value }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Minimal Cuci :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="min_wash_value" placeholder="Masukkan Minimal Cuci (angka)" value="{{ $discountsFind->min_wash_value }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tanggal Diskon Mulai :</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="start_at" placeholder="Masukkan Tanggal Mulai" value="{{ $discountsFind->start_at }}">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2">Tanggal Diskon Berakhir :</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="end_at" placeholder="Masukkan Tanggal Selesai" value="{{ $discountsFind->end_at }}">
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