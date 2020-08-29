<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $table = 'discounts';
    protected $fillable = ['discount_code','discount_desc','discount_type','status','discount_value','min_wash_value','start_at','end_at'];
}
