@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Histori Cuci Motor</h2>
              {{-- <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('bike.create')}}" class="btn btn-success">Tambah</a>
              </div> --}}
            </div>
            
               <!-- Search form -->
            <form action="{{ route('bikehistories.findbyworker')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Masukkan nama pekerja">
                </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
            </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body" style="width: 1050px; height: 600px; overflow: scroll;">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Plat Motor</th>
                  <th>Nama Customer</th>
                  <th>Tipe Cuci</th>
                  <th>Nama Pekerja</th>
                  <th>Nama Admin</th>
                  <th>Jumlah Diskon</th>
                  <th>Jumlah Total</th>
                  <th>Tipe Pembayaran</th>
                  <th>Jumlah Uang Yang Dibayarkan</th>
                  <th>Uang Kembalian</th>
                  <th>Status Pembayaran</th>
                  <th>Disimpan Pada Tanggal</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
                @foreach($bikeshistoriesList as $bikes)
                <tr>
                  <td>{{ $bikes->id }}</td>
                  <td>{{ $bikes->license_plate}}</td>
                  <td>{{ $bikes->customer}}</td>
                  <td>{{ $bikes->wash_type}}</td>
                  <td>{{ $bikes->worker }}</td>
                  <td>{{ $bikes->admin }}</td>
                  <td>{{ $bikes->total_disc }}</td>
                  <td>{{ $bikes->total_pay }}</td>
                  <td>{{ $bikes->type_of_payment }}</td>
                  <td>{{ $bikes->paid_amount }}</td>
                  <td>{{ $bikes->changes }}</td>
                  <td>{{ $bikes->pay_status }}</td>
                  <td>{{ $bikes->saved_at }}</td>
                  {{-- <td>
                      <a href="{{route('bike.delete',['id'=> $bikes->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('bike.edit',['id'=> $bikes->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
                  </td> --}}
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