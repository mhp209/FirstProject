<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{

    use HasFactory;
    protected $table = 'orders';
    protected $guarded= [];

    public function address()
    {
       return $this->hasMany(Address::class,'id','address_id');
    }

    public function orderdetails()
    {
       return $this->hasMany(OrderDetails::class,'order_id','id');
    }

}
