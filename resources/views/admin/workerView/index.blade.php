@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Pegawai</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('worker.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>No Telfon</th>
                  <th>Aksi</th>
                </tr>
                @foreach($workerList as $worker)
                <tr>
                  <td>{{ $worker->id }}</td>
                  <td>{{ $worker->username }}</td>
                  <td>{{ $worker->name }}</td>
                  <td>{{ $worker->address }}</td>
                  <td>{{ $worker->email }}</td>
                  <td>{{ $worker->phone_number }}</td>
                  <td>
                      <a href="{{route('worker.delete',['id'=> $worker->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('worker.edit',['id'=> $worker->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
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