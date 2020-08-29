<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Washtypes extends Model
{
    protected $table = 'wash_type';
    //field yang bisa diisi sekaligus
    protected $fillable = ['wash_type','type_of_goods','type_of_bike','size_of_bike','type_of_carpets','price_per_meter','price'];
}
