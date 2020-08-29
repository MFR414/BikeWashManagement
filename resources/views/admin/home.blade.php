@extends('admin.layout.app')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-10">
            <h3>Cuci Motor</h3>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>{{$bikeData['queues_count']}}</h3>
                    <p>Antrian</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-list"></i>
                  </div>
                  <a href="{{route('bikequeue.index')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>{{$bikeData['booking_count']}}</h3>
                    <p>Booking</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-list"></i>
                  </div>
                  <a href="{{route('bikebooking.index')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>Rp. {{$bikeData['today_earnings']}}</h3>
                    <p>Jumlah Pemasukan Hari Ini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-pricetag"></i>
                  </div>
                  <a href="{{route('bikereport.dailyindex')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>Rp.{{$bikeData['this_month_earnings']}}</h3>
      
                    <p>Jumlah Pemasukan Bulan Ini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-pricetag"></i>
                  </div>
                  <a href="{{route('bikereport.monthlyindex')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <h3>Cuci Karpet</h3>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>{{$carpetData['queues_count']}}</h3>
                    <p>Antrian</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-list"></i>
                  </div>
                  <a href="{{route('carpetqueue.index')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>{{$carpetData['booking_count']}}</h3>
                    <p>Booking</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-list"></i>
                  </div>
                  <a href="{{route('carpetbooking.index')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>Rp. {{$carpetData['today_earnings']}}</h3>
                    <p>Jumlah Pemasukan Hari Ini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-pricetag"></i>
                  </div>
                  <a href="{{route('carpetreport.dailyindex')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>Rp.{{$carpetData['this_month_earnings']}}</h3>
                    <p>Jumlah Pemasukan Bulan Ini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-pricetag"></i>
                  </div>
                  <a href="{{route('carpetreport.monthlyindex')}}" class="small-box-footer"> Info Selanjutnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection