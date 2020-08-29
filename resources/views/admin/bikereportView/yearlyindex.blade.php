@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Laporan Tahunan Cuci Motor</h2>
            </div>
            
               <!-- Search form -->
            <form action="{{ route('bikereport.yearlyindexbydate')}}" method="POST">
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
                  <th style="width: 10px">No</th>
                  <th>Plat Motor</th>
                  <th>Nama Customer</th>
                  <th>Tipe Cuci</th>
                  <th>Jumlah Total</th>
                  <th>Disimpan Pada Tanggal</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
                @foreach($bikesreportList as $urutan=>$bikes)
                <tr>
                  <td>{{ ++$urutan }}</td>
                  <td>{{ $bikes->license_plate}}</td>
                  <td>{{ $bikes->customer}}</td>
                  <td>{{ $bikes->wash_type}}</td>
                  <td>{{ $bikes->total_pay }}</td>
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