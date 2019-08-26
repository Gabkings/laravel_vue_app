<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Orders extends Model
{
    //
    use SoftDeletes;
    protected $fillable =[
    	'order_number'
    ];
    protected $table = "orders";
}
