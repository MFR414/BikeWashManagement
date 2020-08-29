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
               <form class="form-horizontal" action="{{ route('carpetqueue.update',['id'=> $carpetqueuesFind[0]->id]) }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Warna Karpet :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="color_of_carpet" value="{{$carpetqueuesFind[0]->color_of_carpet}}" placeholder="Masukkan Warna Karpet (Gunakan huruf kecil, Contoh: merah)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Jenis Karpet :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="type_of_carpet" value="{{$carpetqueuesFind[0]->type_of_carpet}}"placeholder="Masukkan Jenis Karpet (Gunakan huruf kecil,Jenis Karpet : tipis, medium, super)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama Pemilik :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="customer_name" value="{{$carpetqueuesFind[0]->customer}}" placeholder="Masukkan Nama Pemilik (Gunakan huruf kecil)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Jenis Cuci :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="wash_type" value="{{$carpetqueuesFind[0]->wash_type}}" placeholder="Masukkan Jenis Cuci (Jenis Cuci : standar)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama Pegawai 1 :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="worker1_name">
                                @foreach($workerList as $worker)
                                  <option value="{{ $worker->name }}" {{ ( $worker->name == $carpetqueuesFind[0]->worker1) ? 'selected' : '' }}>{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama Pegawai 2 :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="worker2_name">
                                @foreach($workerList as $worker)
                                  <option value="{{ $worker->name }}" {{ ( $worker->name == $carpetqueuesFind[0]->worker2) ? 'selected' : '' }}>{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Estimasi Waktu Selesai :</label>
                        <div class="col-sm-10" >
                            <input type="date" class="form-control" name="estimation_time_date" value="{{$carpetqueuesFind[0]->estimation_time}}" placeholder="Estimasi Waktu Selesai" id="txtDate">
                        </div>
                    </div>

                    <script type="text/javascript">
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; //January is 0!
                        var yyyy = today.getFullYear();
                        if(dd<10){
                                dd='0'+dd
                            } 
                            if(mm<10){
                                mm='0'+mm
                            } 
                        today = yyyy+'-'+mm+'-'+dd;
                        document.getElementById("txtDate").setAttribute("min", today);
                        
                    </script>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Status :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                @for($a=0;$a<count($status);$a++)
                                  <option value="{{$status[$a]['status']}}" {{ ( $status[$a]['status'] == $carpetqueuesFind[0]->status) ? 'selected' : '' }}>{{$status[$a]['name'] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Tambah</button>
                        </div>
                    </div>
                </form> 
           </div>
        </div>
    </div>
</section>
@endsection