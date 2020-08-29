@extends('owner.home')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Admin</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('owner.admin.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Posisi</th>
                  <th>No Telfon</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
                @foreach($adminList as $admin)
                <tr>
                  <td>{{ $admin->id }}</td>
                  <td>{{ $admin->username }}</td>
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>{{ $admin->posisi }}</td>
                  <td>{{ $admin->phone_number }}</td>
                  <td>
                      <a href="{{route('owner.admin.delete',['id'=> $admin->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('owner.admin.edit',['id'=> $admin->id])}}" class="btn btn-warning">Ubah</a>
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