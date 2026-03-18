<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HireEnquiry extends Model
{
    use HasFactory;

    protected $fillable = ['first_name','last_name','mobile_number','email', 'hire_name','status','pickup_city','dest_city','trip_type','type_vehicle'];
}
