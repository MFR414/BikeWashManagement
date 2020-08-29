<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BikeQueues extends Model
{
    protected $table = 'bike_queues';
    protected $fillable = ['customer_id','bike_id','worker_id','washtype_id','status','estimation_time','booking_date','queue_number'];
}
