<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BikeHistories extends Model
{
    protected $table = 'bike_histories';
    protected $fillable = ['total_disc','total_pay','paid_amount','changes','pay_status','type_of_payment','rating','cust_id','bike_id','admin_id','worker_id','discount_id','washtype_id','saved_at'];
}
