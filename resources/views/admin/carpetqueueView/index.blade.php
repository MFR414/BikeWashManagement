@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Antrian Karpet</h2>
              <div class="pagination pagination-sm no-margin pull-right">
              <a href="{{route('carpetqueue.create')}}" class="btn btn-success">Tambah</a>
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
                  <th style="width: 10px">No Antrian</th>
                  <th style="width: 10px">Id</th>
                  <th>Warna Karpet</th>
                  <th>Jenis Karpet</th>
                  <th>Nama Pemilik</th>
                  <th>Nama Pekerja 1</th>
                  <th>Nama Pekerja 2</th>
                  <th>Jenis Cuci</th>
                  <th>Estimasi Waktu Selesai</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                @foreach($carpetqueuesList as $carpetqueues)
                <tr>
                  <td>{{ $carpetqueues->queue_number }}</td>
                  <td>{{ $carpetqueues->id}}</td>
                  <td>{{ $carpetqueues->color_of_carpet}}</td>
                  <td>{{ $carpetqueues->type_of_carpet}}</td>
                  <td>{{ $carpetqueues->customer}}</td>
                  <td>{{ $carpetqueues->worker1}}</td>
                  <td>{{ $carpetqueues->worker2 }}</td>
                  <td>{{ $carpetqueues->wash_type }}</td>
                  <td>{{ $carpetqueues->estimation_time }}</td>
                  <td>{{ $carpetqueues->status }}</td>
                  <td>
                      <a href="{{route('carpetqueue.delete',['id'=> $carpetqueues->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Cancel Antrian</a>
                      <a href="{{route('carpetqueue.edit',['id'=> $carpetqueues->id])}}" class="btn btn-primary" onclick="return confirm('Edit this Data?')">Ubah</a>
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