<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $fillable = ['telecaller_id','vehicle_id','vehicle_no','caller_name','caller_number','location','description','status'];
}
