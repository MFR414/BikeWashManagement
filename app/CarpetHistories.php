<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarpetHistories extends Model
{
    protected $table = 'carpet_histories';
    protected $fillable = ['total_disc','total_pay','paid_amount','changes','pay_status','type_of_payment','rating','created_at','bike_queue_id','cust_id','carpet_id','admin_id','worker1_id','worker2_id','discount_id','washtype_id','saved_at'];
}
