<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carpets extends Model
{
    protected $table = 'carpets';
    protected $fillable = ['color_of_carpet','type_of_carpet','length_of_carpets','width_of_carpets','amount_of_wash','note','customer_id'];
}
