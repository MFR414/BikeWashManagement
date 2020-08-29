@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Edit Pekerja</h3>
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
               <form class="form-horizontal" action="{{ route('admin.update',['id'=> $adminFind->id]) }}" method="POST">
                @csrf
                    <div class="form-group">
                    <label class="control-label col-sm-2">Username :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" placeholder="Masukkan Username (huruf kecil)" value="{{ $adminFind->username }}">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password (huruf kecil)" value="{{ $adminFind->password }}">
                    </div>
                    </div>
                   
                    <div class="form-group">
                    <label class="control-label col-sm-2">Nama :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama (huruf kecil)" value="{{ $adminFind->name }}">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2">Email :</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email (huruf kecil)" value="{{ $adminFind->email }}">
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Posisi :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" placeholder="Masukkan Posisi (huruf kecil)" value="{{ $adminFind->position }}">
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">No.Telp :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone_number" placeholder="Masukkan Nomor Telefon (huruf kecil)" value="{{ $adminFind->phone_number }}">
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