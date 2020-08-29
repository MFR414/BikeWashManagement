@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Edit Antrian Motor</h3>
               </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
                @endif
                <form class="form-horizontal" action="{{ route('bikequeue.update',['id'=> $bikequeueData['id']]) }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Plat Nomor :</label>
                        <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{$bikequeueData['license_plate']}}" name="license_plate" placeholder="Masukkan Nomor Plat (contoh:N234YA)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Jenis Cuci :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" value="{{$bikequeueData['wash_type']}}" name="wash_type" placeholder="Masukkan Jenis Cuci (Jenis Cuci : standar, silikon)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama Pegawai :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="worker_name">
                                @foreach($workerList as $worker)
                                  <option value="{{ $worker->name }}" {{ ( $worker->name == $bikequeueData['worker_name']) ? 'selected' : '' }}>{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="control-label col-sm-2">Estimasi Waktu Selesai :</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{$bikequeueData['estimation_time_hour']}}" name="estimation_time_hour" placeholder="Jam">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{$bikequeueData['estimation_time_minute']}}" name="estimation_time_minute" placeholder="Menit">
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="control-label col-sm-2">Status :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                @for($a=0;$a<count($status);$a++)
                                  <option value="{{$status[$a]['status']}}" {{ ( $status[$a]['status'] == $bikequeueData['status']) ? 'selected' : '' }}>{{$status[$a]['name'] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Simpan</button>
                        </div>
                    </div>
                </form> 
           </div>
        </div>
    </div>
</section>
@endsection