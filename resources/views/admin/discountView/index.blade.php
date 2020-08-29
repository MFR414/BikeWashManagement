@extends('admin.layout.app')

@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h2 class="box-title">Daftar Diskon</h2>
              <div class="pagination pagination-sm no-margin pull-right">
                <a href="{{route('discount.create')}}" class="btn btn-success">Tambah</a>
              </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Kode Diskon</th>
                  <th>Keterangan Diskon</th>
                  <th>Tipe Diskon</th>
                  <th>Status</th>
                  <th>Besar Diskon</th>
                  <th>Minimal Jumlah Cuci</th>
                  <th>Tgl. Mulai</th>
                  <th>Tgl. Berakhir</th>
                  <th>Aksi</th>
                </tr>
                @foreach($discountsList as $discount)
                <tr>
                  <td>{{ $discount->id }}</td>
                  <td>{{ $discount->discount_code }}</td>
                  <td>{{ $discount->discount_desc }}</td>
                  <td>{{ $discount->discount_type }}</td>
                  <td>{{ $discount->status }}</td>
                  <td>{{ $discount->discount_value }}</td>
                  <td>{{ $discount->min_wash_value }}</td>
                  <td>{{ $discount->start_at }}</td>
                  <td>{{ $discount->end_at }}</td>
                  <td>
                      <a href="{{route('discount.delete',['id'=> $discount->id])}}" class="btn btn-danger" onclick="return confirm('Delete this Data?')">Hapus</a>
                      <a href="{{route('discount.edit',['id'=> $discount->id])}}" class="btn btn-warning" onclick="return confirm('Edit this Data?')">Ubah</a>
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