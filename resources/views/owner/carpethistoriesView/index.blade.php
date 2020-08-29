@extends('owner.home')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Histori Cuci Karpet</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('owner.carpethistories.export')}}" class="btn btn-success">Export To Excel</a>
              </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Warna Carpet</th>
                  <th>Tipe Carpet</th>
                  <th>Nama Customer</th>
                  <th>Tipe Cuci</th>
                  <th>Nama Pekerja 1</th>
                  <th>Nama Pekerja 2</th>
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
                @foreach($carpetshistoriesList as $carpets)
                <tr>
                  <td>{{ $carpets->id }}</td>
                  <td>{{ $carpets->color_of_carpet}}</td>
                  <td>{{ $carpets->type_of_carpet}}</td>
                  <td>{{ $carpets->customer}}</td>
                  <td>{{ $carpets->wash_type}}</td>
                  <td>{{ $carpets->worker1 }}</td>
                  <td>{{ $carpets->worker2 }}</td>
                  <td>{{ $carpets->admin }}</td>
                  <td>{{ $carpets->total_disc }}</td>
                  <td>{{ $carpets->total_pay }}</td>
                  <td>{{ $carpets->type_of_payment }}</td>
                  <td>{{ $carpets->paid_amount }}</td>
                  <td>{{ $carpets->changes }}</td>
                  <td>{{ $carpets->pay_status }}</td>
                  <td>{{ $carpets->saved_at }}</td>
                  
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