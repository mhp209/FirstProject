<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsAlert extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id',
        'user_id',
        'vehicle_id',
        'mobile_number',
        'vehicle_no',
        'type',
        'message',
        'device'
    ];
}
