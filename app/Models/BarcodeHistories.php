<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarcodeHistories extends Model
{
    use HasFactory;

    protected $fillable = ['assign_to', 'wheeler_type' ,'count', 'code'];
}
