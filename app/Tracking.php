<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'trackings';
    protected $fillable = ['date','order_number', 'name','address','phone_number','area', 'actual_weight','weight_cost','cost','declared_value','delivery_status','aging','remarks'];

}
