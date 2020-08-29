@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Booking Antrian Karpet</h2>
              <div class="pagination pagination-sm no-margin pull-right">
              <a href="{{route('carpetbooking.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            @if (session('status'))
            <div class="alert alert-danger">
                <h4>{{ session('status') }}</h4>
            </div><br>
            @endif
            
             {{-- <!-- Search form -->
            <form action="{{ route('carpet.findPlate')}}" method="POST">
              @csrf
              <div class="form-group">
              <div class="col-sm-11">
                  <input type="text" class="form-control" name="search_name" placeholder="Enter License Plate">
              </div>
                  <button class="btn btn-primary" type="submit">Cari</button>
              </div>
            </form> --}}

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">No.</th>
                  <th style="width: 10px">No Antrian</th>
                  <th>Warna Karpet</th>
                  <th>Jenis Karpet</th>
                  <th>Nama Pemilik</th>
                  <th>Jenis Cuci</th>
                  <th>Tanggal Booking</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                @foreach($carpetqueuesList as $antri=>$carpetqueues)
                <tr>
                  <td>{{ ++$antri }}</td>
                  <td>{{ $carpetqueues->queue_number}}</td>
                  <td>{{ $carpetqueues->color_of_carpet}}</td>
                  <td>{{ $carpetqueues->type_of_carpet}}</td>
                  <td>{{ $carpetqueues->customer}}</td>
                  <td>{{ $carpetqueues->wash_type }}</td>
                  <td>{{ $carpetqueues->booking_date }}</td>
                  <td>{{ $carpetqueues->status }}</td>
                  <td>
                      <a href="{{route('carpetbooking.delete',['id'=> $carpetqueues->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Cancel Antrian</a>
                      <a href="{{route('carpetbooking.edit',['id'=> $carpetqueues->id])}}" class="btn btn-primary" onclick="return confirm('Edit this Data?')">Ubah</a>
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