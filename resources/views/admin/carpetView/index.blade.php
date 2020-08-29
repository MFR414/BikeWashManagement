@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Karpet</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('carpet.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            
             <!-- Search form -->
            <form action="{{ route('carpet.findColor')}}" method="POST">
              @csrf
              <div class="form-group">
              <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Enter Carpet Color">
              </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
              </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Warna Karpet</th>
                  <th>Jenis Karpet</th>
                  <th>Panjang Karpet</th>
                  <th>Lebar Karpet</th>
                  <th>Jumlah Cuci</th>
                  <th>Catatan</th>
                  <th>Nama Customer</th>
                  <th>Aksi</th>
                </tr>
                @foreach($carpetsList as $carpets)
                <tr>
                  <td>{{ $carpets->id }}</td>
                  <td>{{ $carpets->color_of_carpet }}</td>
                  <td>{{ $carpets->type_of_carpet }}</td>
                  <td>{{ $carpets->length_of_carpets}}</td>
                  <td>{{ $carpets->width_of_carpets}}</td>
                  <td>{{ $carpets->amount_of_wash }}</td>
                  <td>{{ $carpets->note }}</td>
                  <td>{{ $carpets->name }}</td>
                  <td>
                      <a href="{{route('carpet.delete',['id'=> $carpets->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('carpet.edit',['id'=> $carpets->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
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