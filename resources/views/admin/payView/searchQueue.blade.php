@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Cari Antrian</h3>
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
                @if (session('status'))
                <div class="alert alert-danger">
                    <h4>{{ session('status') }}</h4>
                </div>
                @endif
            <form class="form-horizontal" action="{{ route('paying.search')}}" method="POST">
                @csrf
                    <div class="form-group">
                    <label class="control-label col-sm-2">Id Antrian :</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="id_antri" placeholder="Masukkan Id Antrian (Angka)">
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Jenis Antrian :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="jenis_antri">
                                <option value="bike">Motor</option>
                                <option value="carpet">Karpet</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Cari</button>
                    </div>
                    </div>
                </form> 
           </div>
        </div>
    </div>
</section>
@endsection