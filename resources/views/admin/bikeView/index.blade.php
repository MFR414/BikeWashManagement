@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Motor</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('bike.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            
             <!-- Search form -->
            <form action="{{ route('bike.findPlate')}}" method="POST">
              @csrf
              <div class="form-group">
              <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Enter License Plate">
              </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
              </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Plat Motor</th>
                  <th>Tipe Motor</th>
                  <th>Ukuran Motor</th>
                  <th>Jumlah Cuci</th>
                  <th>Catatan</th>
                  <th>Nama Customer</th>
                  <th>Aksi</th>
                </tr>
                @foreach($bikesList as $bikes)
                <tr>
                  <td>{{ $bikes->id }}</td>
                  <td>{{ $bikes->license_plate }}</td>
                  <td>{{ $bikes->type_of_bike}}</td>
                  <td>{{ $bikes->size_of_bike}}</td>
                  <td>{{ $bikes->amount_of_wash }}</td>
                  <td>{{ $bikes->note }}</td>
                  <td>{{ $bikes->name }}</td>
                  <td>
                      <a href="{{route('bike.delete',['id'=> $bikes->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('bike.edit',['id'=> $bikes->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{-- <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li> --}}
              </ul>
            </div>
          </div>
        </div>
    </div>
</section>

@endsection