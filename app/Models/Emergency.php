<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;

    protected $fillable = ['telecaller_id','vehicle_id','vehicle_no','caller_name','caller_number','location','description','status'];

    public function EmergencyHistories()
	{
		return $this->hasOne(EmergencyHistories::class, 'emergency_id', 'id');
	}

    public function adminRole()
    {
        return $this->hasOne(Admin::class, 'id','telecaller_id');
    }
}
