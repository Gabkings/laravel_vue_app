<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order_details extends Model
{
    //
    use SoftDeletes;

    protected $fillable =[
    	'order_id','product_id'
    ];
    protected $table = "order_details";
}
