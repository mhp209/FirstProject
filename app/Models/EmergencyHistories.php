<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyHistories extends Model
{
    use HasFactory;

    protected $fillable = ['emergency_id', 'status', 'details'];

    public function Emergency()
    {
        return $this->hasOne(Emergency::class,'id','emergency_id');
    }

}
