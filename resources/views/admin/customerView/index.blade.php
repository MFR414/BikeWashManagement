@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Pelanggan</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('customer.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>

              <!-- Search form -->
            <form action="{{ route('customer.findIndex')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Enter Customer Name">
                </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
            </div>
            </form>
            
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
                  <th>Jumlah Deposit</th>
                  <th>Aksi</th>
                </tr>
                @foreach($customerList as $customer)
                <tr>
                  <td>{{ $customer->id }}</td>
                  <td>{{ $customer->username }}</td>
                  <td>{{ $customer->name }}</td>
                  <td>{{ $customer->address }}</td>
                  <td>{{ $customer->email }}</td>
                  <td>{{ $customer->phone_number }}</td>
                  <td>Rp.{{ $customer->deposited_money }}</td>
                  <td>
                      <a href="{{route('customer.delete',['id'=> $customer->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('customer.edit',['id'=> $customer->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
                      <a href="{{route('customer.addMoney',['id'=> $customer->id])}}" class="btn btn-success">Tambah Deposit</a>
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