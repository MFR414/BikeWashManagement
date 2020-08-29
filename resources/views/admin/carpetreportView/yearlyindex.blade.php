@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Laporan Tahunan Cuci Karpet</h2>
              {{-- <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('bike.create')}}" class="btn btn-success">Tambah</a>
              </div> --}}
            </div>
            
                <!-- Search form -->
            <form action="{{ route('carpetreport.yearlyindexbydate')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="col-sm-10">
                  <select class="form-control" name="year_filter">
                    <option selected>Pilih Tahun</option>
                    @for($year = 2015; $year <= 3000; $year++)
                      <option value="{{$year}}">{{$year}}</option>
                    @endfor
                  </select>
                </div>
                <button class="btn btn-primary" type="submit">Filter Bulan</button>
              </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body" style="width: 1050px; height: 600px; overflow: scroll;">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">No.</th>
                  <th>Warna Carpet</th>
                  <th>Tipe Carpet</th>
                  <th>Nama Customer</th>
                  <th>Tipe Cuci</th>
                  <th>Tipe Pembayaran</th>
                  <th>Jumlah Total</th>
                  <th>Disimpan Pada Tanggal</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
                @foreach($carpetsreportList as $urutan=>$carpets)
                <tr>
                  <td>{{ ++$urutan}}</td>
                  <td>{{ $carpets->color_of_carpet}}</td>
                  <td>{{ $carpets->type_of_carpet}}</td>
                  <td>{{ $carpets->customer}}</td>
                  <td>{{ $carpets->type_of_payment}}</td>
                  <td>{{ $carpets->wash_type}}</td>
                  <td>{{ $carpets->total_pay }}</td>
                  <td>{{ $carpets->saved_at }}</td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <h4 class="control-label col-sm-2">Total Pemasukan :</h4>
                <div class="col-sm-10">
                <h4> Rp.{{$sumreport}}</h4>
                </div>
            </div>
          </div>
        </div>
    </div>
</section>

@endsection