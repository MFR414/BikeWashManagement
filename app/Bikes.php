<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bikes extends Model
{
    protected $table = 'bikes';
    protected $fillable = ['license_plate','type_of_bike','size_of_bike','amount_of_wash','note','customer_id'];
}
