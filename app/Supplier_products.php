<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier_products extends Model
{
    //
    use SoftDeletes;
    protected $fillable =[
    	'supply_id','product_id'
    ];
    protected $table = "supplier_products";
}
