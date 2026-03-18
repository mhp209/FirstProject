<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderDate extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'vehicle_id', 'puc_expiry_date_reminder', 'license_expiry_date_reminder','insurance_expiry_date_reminder'];
}
