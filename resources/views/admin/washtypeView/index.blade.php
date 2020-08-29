@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Jenis Cuci</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('washtype.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            
             <!-- Search form -->
            <form action="{{ route('washtype.findWashtype')}}" method="POST">
              @csrf
              <div class="form-group">
              <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Enter Wash Type">
              </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
              </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Tipe Cuci</th>
                  <th>Tipe Barang</th>
                  <th>Tipe Motor</th>
                  <th>Ukuran Motor</th>
                  <th>tipe Karpet</th>
                  <th>Harga Per Meter</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
                @foreach($washtypeList as $washtypes)
                <tr>
                  <td>{{ $washtypes->id }}</td>
                  <td>{{ $washtypes->wash_type }}</td>
                  <td>{{ $washtypes->type_of_goods}}</td>
                  <td>{{ $washtypes->type_of_bike}}</td>
                  <td>{{ $washtypes->size_of_bike}}</td>
                  <td>{{ $washtypes->type_of_carpets}}</td>
                  <td>{{ $washtypes->price_per_meter }}</td>
                  <td>{{ $washtypes->price }}</td>
                  <td>
                      <a href="{{route('washtype.delete',['id'=> $washtypes->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('washtype.edit',['id'=> $washtypes->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
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