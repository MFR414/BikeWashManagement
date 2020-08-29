<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';
    //field yang bisa diisi sekaligus
    protected $fillable = ['username','password','name','address','email','phone_number','deposited_money'];
}

