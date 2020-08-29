<?php

namespace App\Exports;

use App\BikeHistories;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\Exportable;
use Illuminate\Support\Facades\DB;

class BikeHistoriesExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return  $bikeshistoriesList= DB::table('bike_histories')
        ->join('customers', 'bike_histories.cust_id', '=', 'customers.id')
        ->join('bikes', 'bike_histories.bike_id', '=', 'bikes.id')
        ->join('workers', 'bike_histories.worker_id', '=', 'workers.id')
        ->leftjoin('discounts', 'bike_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'bike_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'bike_histories.washtype_id', '=', 'wash_type.id')
        ->select('bike_histories.id','bikes.license_plate','customers.name as customer','wash_type.wash_type','workers.name as worker','admins.name as admin','bike_histories.total_pay','bike_histories.total_disc','bike_histories.pay_status','bike_histories.type_of_payment','bike_histories.paid_amount','bike_histories.changes','bike_histories.created_at','bike_histories.rating')
        ->orderby('id','asc');
    }

    public function headings(): array
    {
        return [
            'Id',
            'Plat Motor',
            'Nama Customer',
            'Tipe Cuci',
            'Nama Pekerja',
            'Nama Admin',
            'Jumlah Total',
            'Jumlah Diskon',
            'Status Pembayaran',
            'Tipe Pembayaran',
            'Jumlah Uang Yang Dibayarkan',
            'Uang Kembalian',
            'Dibuat Pada Tanggal',
            'Rating',
        ];
    }
}
