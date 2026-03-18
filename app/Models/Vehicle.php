<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','owner_name','barcode','brand','model', 'mobile_number', 'vehicle_no','vehicle_type','image','license_no','rc_no','emergency_name1','relation_emg1','emergency_number1','emergency_name2','relation_emg2','emergency_number2','puc_ending_date','license_ending_date','inurance_ending_date','service_date'];

    public function VehicleDocuments()
    {
        return $this->hasMany(VehicleDocuments::class,'vehicle_id');
    }

    public function ReminderDate()
    {
        return $this->hasOne(ReminderDate::class,'vehicle_id');
    }

    public function VehicleBrand()
    {
        return $this->hasOne(VehicleBrand::class,'id','brand');
    }

    public function VehicleModel()
    {
        return $this->hasOne(VehicleModel::class,'id','model');
    }

}

