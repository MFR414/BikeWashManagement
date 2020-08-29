@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3>Form Tambah Booking Antrian Motor</h3>
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
                
               <form class="form-horizontal" action="{{ route('bikebooking.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2">Plat Nomor :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="license_plate" placeholder="Masukkan Nomor Plat (contoh:N234YA)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Jenis Cuci :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="wash_type" placeholder="Masukkan Jenis Cuci (Jenis Cuci : standar, silikon)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Tanggal Booking :</label>
                        <div class="col-sm-10" >
                            <input type="date" class="form-control" name="booking_date" placeholder="Tanggal Booking" id="txtDate">
                        </div>
                    </div>

                    <script type="text/javascript">
                        var today = new Date();
                        var dd = today.getDate()+1;
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