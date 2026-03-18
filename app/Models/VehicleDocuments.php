<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDocuments extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id','type','name'];

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
}
