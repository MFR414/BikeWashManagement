@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Deposit</h3>
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
               <form class="form-horizontal" action="{{ route('customer.addMoneyUpdate',['id'=> $customerFind->id]) }}" method="POST">
                @csrf
                    <div class="form-group">
                    <label class="control-label col-sm-2">Jumlah Uang Yang Ditambahkan :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="addingMoney" placeholder="Masukkan Jumlah Uang (Angka tanpa titik)">
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