<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarpetQueues extends Model
{
    protected $table = 'carpet_queues';
    protected $fillable = ['customer_id','carpet_id','worker1_id','worker2_id','washtype_id','status','estimation_time','booking_date','queue_number'];
}
