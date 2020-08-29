<?php

namespace App\Exports;

use App\CarpetHistories;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\Exportable;
use Illuminate\Support\Facades\DB;


class CarpetHistoriesExport implements FromQuery, WithHeadings
{

    public function query()
    {
        return DB::table('carpet_histories')
        ->join('customers', 'carpet_histories.cust_id', '=', 'customers.id')
        ->join('carpets', 'carpet_histories.carpet_id', '=', 'carpets.id')
        ->join('workers as worker1', 'carpet_histories.worker1_id', '=', 'worker1.id')
        ->join('workers as worker2', 'carpet_histories.worker2_id', '=', 'worker2.id')
        ->leftjoin('discounts', 'carpet_histories.discount_id', '=', 'discounts.id')
        ->join('admins', 'carpet_histories.admin_id', '=', 'admins.id')
        ->join('wash_type', 'carpet_histories.washtype_id', '=', 'wash_type.id')
        ->select('carpet_histories.id','carpets.color_of_carpet','carpets.type_of_carpet','customers.name as customer','wash_type.wash_type','worker1.name as worker1','worker2.name as worker2','admins.name as admin','carpet_histories.total_disc','carpet_histories.total_pay','carpet_histories.pay_status','carpet_histories.type_of_payment','carpet_histories.paid_amount','carpet_histories.changes','carpet_histories.created_at','carpet_histories.rating')
        ->orderby('id','asc');
    }

    public function headings(): array
    {
        return [
            'Id',
            'Warna Carpet',
            'Tipe Carpet',
            'Nama Customer',
            'Tipe Cuci',
            'Nama Pekerja 1',
            'Nama Pekerja 2',
            'Nama Admin',
            'Jumlah Diskon',
            'Jumlah Total',
            'Status Pembayaran',
            'Tipe Pembayaran',
            'Jumlah Uang Yang Dibayarkan',
            'Uang Kembalian',
            'Dibuat Pada Tanggal',
            'Rating',
        ];
    }
}
