<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    protected $table = 'workers';
    //field yang bisa diisi sekaligus
    protected $fillable = ['username','password','name','address','email','phone_number'];
}


